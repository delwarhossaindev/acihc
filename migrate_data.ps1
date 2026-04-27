param(
    [string]$MssqlServer = ".\SQLEXPRESS",
    [string]$MssqlDb = "AciHealthcare",
    [string]$MysqlBin = "d:/wamp64/bin/mysql/mysql8.2.0/bin/mysql.exe",
    [string]$MysqlUser = "root",
    [string]$MysqlDb = "acihealthcare",
    [string]$DumpDir = "d:/wamp64/www/acihc/_migration_dump"
)

$ErrorActionPreference = "Stop"
if (-not (Test-Path $DumpDir)) { New-Item -ItemType Directory -Path $DumpDir | Out-Null }

Add-Type -AssemblyName "System.Data"

function Get-MssqlConnection {
    $cs = "Server=$MssqlServer;Database=$MssqlDb;Integrated Security=true;TrustServerCertificate=true;"
    $conn = New-Object System.Data.SqlClient.SqlConnection($cs)
    $conn.Open()
    return $conn
}

function Escape-MysqlString([string]$s) {
    if ($null -eq $s) { return "NULL" }
    $s = $s -replace '\\','\\'
    $s = $s -replace "'","''"
    $s = $s -replace "`r`n","\n"
    $s = $s -replace "`n","\n"
    $s = $s -replace "`r","\n"
    $s = $s -replace [char]0,''
    return "'$s'"
}

function Format-Value($v) {
    if ($v -eq [System.DBNull]::Value -or $null -eq $v) { return "NULL" }
    if ($v -is [bool])     { return $(if ($v) { "1" } else { "0" }) }
    if ($v -is [datetime]) { return "'" + $v.ToString("yyyy-MM-dd HH:mm:ss") + "'" }
    if ($v -is [byte[]])   {
        $hex = ($v | ForEach-Object { $_.ToString("x2") }) -join ""
        return "0x$hex"
    }
    if ($v -is [int] -or $v -is [long] -or $v -is [decimal] -or $v -is [double] -or $v -is [single] -or $v -is [int16] -or $v -is [byte]) {
        return $v.ToString([System.Globalization.CultureInfo]::InvariantCulture)
    }
    return Escape-MysqlString ([string]$v)
}

# Tables in MSSQL to skip (Laravel system tables that migrate already populated, or tables needing special handling)
$skipTables = @('migrations')

# Discover tables and row counts
$conn = Get-MssqlConnection
$cmd = $conn.CreateCommand()
$cmd.CommandText = "SELECT t.name AS TableName FROM sys.tables t WHERE t.is_ms_shipped = 0 ORDER BY t.name"
$reader = $cmd.ExecuteReader()
$tables = @()
while ($reader.Read()) { $tables += $reader["TableName"] }
$reader.Close()
$conn.Close()

Write-Host "Found $($tables.Count) tables in MSSQL." -ForegroundColor Cyan

# Build a map of MySQL columns per table so we only insert columns that exist on both sides
Write-Host "Reading MySQL schema..." -ForegroundColor Cyan
$mysqlColsRaw = & $MysqlBin -u $MysqlUser -N -B -e "SELECT TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='$MysqlDb'"
$mysqlCols = @{}
foreach ($line in $mysqlColsRaw) {
    if ($line -match "^(\S+)\s+(\S+)$") {
        $tn = $matches[1]; $cn = $matches[2]
        if (-not $mysqlCols.ContainsKey($tn)) { $mysqlCols[$tn] = New-Object System.Collections.Generic.HashSet[string] }
        [void]$mysqlCols[$tn].Add($cn)
    }
}
Write-Host ("MySQL has {0} tables." -f $mysqlCols.Count) -ForegroundColor Cyan

$globalSql = Join-Path $DumpDir "all_data.sql"
"SET FOREIGN_KEY_CHECKS=0;" | Out-File -FilePath $globalSql -Encoding ASCII
"SET UNIQUE_CHECKS=0;"      | Add-Content -Path $globalSql -Encoding ASCII
"SET sql_mode='NO_AUTO_VALUE_ON_ZERO';" | Add-Content -Path $globalSql -Encoding ASCII

foreach ($t in $tables) {
    if ($skipTables -contains $t) { Write-Host "  skip $t" -ForegroundColor DarkGray; continue }

    $conn = Get-MssqlConnection
    $cnt = $conn.CreateCommand()
    $cnt.CommandText = "SELECT COUNT(*) FROM [$t]"
    $rows = [int]$cnt.ExecuteScalar()
    if ($rows -eq 0) {
        Write-Host "  empty $t" -ForegroundColor DarkGray
        $conn.Close(); continue
    }

    if (-not $mysqlCols.ContainsKey($t)) {
        Write-Host "  no MySQL table for $t (skip)" -ForegroundColor Yellow
        $conn.Close(); continue
    }

    $cmd = $conn.CreateCommand()
    $cmd.CommandText = "SELECT * FROM [$t]"
    $rd = $cmd.ExecuteReader()

    $allCols = @()
    for ($i = 0; $i -lt $rd.FieldCount; $i++) { $allCols += $rd.GetName($i) }
    # Keep only columns that exist in MySQL
    $useIdx = @()
    $useNames = @()
    for ($i = 0; $i -lt $allCols.Count; $i++) {
        if ($mysqlCols[$t].Contains($allCols[$i])) {
            $useIdx += $i
            $useNames += $allCols[$i]
        }
    }
    if ($useNames.Count -eq 0) {
        Write-Host "  no overlapping columns for $t (skip)" -ForegroundColor Yellow
        $rd.Close(); $conn.Close(); continue
    }
    $skipped = $allCols | Where-Object { $useNames -notcontains $_ }
    if ($skipped.Count -gt 0) { Write-Host ("  ${t}: skipping cols " + ($skipped -join ',')) -ForegroundColor DarkYellow }

    $colList = ($useNames | ForEach-Object { "``$_``" }) -join ","

    $sb = New-Object System.Text.StringBuilder
    [void]$sb.AppendLine("-- $t ($rows rows)")
    [void]$sb.AppendLine("DELETE FROM ``$t``;")

    $batchSize = 200
    $batchVals = @()
    $batchCount = 0
    $totalCount = 0

    while ($rd.Read()) {
        $vals = @()
        foreach ($i in $useIdx) { $vals += Format-Value $rd.GetValue($i) }
        $batchVals += "(" + ($vals -join ",") + ")"
        $batchCount++; $totalCount++

        if ($batchCount -ge $batchSize) {
            [void]$sb.AppendLine("INSERT INTO ``$t`` ($colList) VALUES")
            [void]$sb.AppendLine(($batchVals -join ",`n") + ";")
            $batchVals = @(); $batchCount = 0
        }
    }
    if ($batchCount -gt 0) {
        [void]$sb.AppendLine("INSERT INTO ``$t`` ($colList) VALUES")
        [void]$sb.AppendLine(($batchVals -join ",`n") + ";")
    }

    $rd.Close(); $conn.Close()

    $sb.ToString() | Add-Content -Path $globalSql -Encoding UTF8
    Write-Host "  dumped $t ($totalCount rows)" -ForegroundColor Green
}

"SET FOREIGN_KEY_CHECKS=1;" | Add-Content -Path $globalSql -Encoding ASCII
"SET UNIQUE_CHECKS=1;"      | Add-Content -Path $globalSql -Encoding ASCII

Write-Host "`nDump complete: $globalSql" -ForegroundColor Cyan
$sz = (Get-Item $globalSql).Length / 1MB
Write-Host ("Size: {0:N2} MB" -f $sz)

Write-Host "`nImporting into MySQL '$MysqlDb'..." -ForegroundColor Cyan
& $MysqlBin -u $MysqlUser --default-character-set=utf8mb4 $MysqlDb -e "source $globalSql"
if ($LASTEXITCODE -eq 0) {
    Write-Host "Import OK." -ForegroundColor Green
} else {
    Write-Host "Import FAILED with exit $LASTEXITCODE" -ForegroundColor Red
}
