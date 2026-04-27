# Setup Guide — Multi-Database Support

এই project তিনটা database support করে: **MySQL**, **MS SQL Server (sqlsrv)**, এবং **SQLite**। যেকোনো একটা use করতে নিচের instructions follow করুন।

---

## 🚀 Quick Start (সব DB-এর জন্য common)

```bash
# 1. Dependencies install
composer install

# 2. App key generate
php artisan key:generate

# 3. Storage link
php artisan storage:link

# 4. Migrations run (DB select করার পর)
php artisan migrate
```

---

## 🐬 Option 1: MySQL (Recommended for WAMP/XAMPP)

### Step 1: MySQL-এ database create

```sql
CREATE DATABASE acihealthcare CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

WAMP/XAMPP-এর phpMyAdmin দিয়েও create করতে পারেন।

### Step 2: `.env`-এ এই block uncomment রাখুন (default)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=acihealthcare
DB_USERNAME=root
DB_PASSWORD=
```

### Step 3: PHP extension verify

```bash
php -m | grep -i pdo_mysql
```

WAMP-এ default enabled থাকে। না থাকলে `php.ini`-তে `extension=pdo_mysql` uncomment করুন।

### Step 4: Migrate

```bash
php artisan migrate
```

---

## 🟦 Option 2: MS SQL Server

### Step 1: PHP extension install

`pdo_sqlsrv` এবং `sqlsrv` extensions install করতে হবে।

```bash
# Check if installed
php -m | grep -i sqlsrv
```

না থাকলে [Microsoft drivers download](https://learn.microsoft.com/en-us/sql/connect/php/download-drivers-for-php-for-sql-server) করে `php/ext/` ফোল্ডারে রেখে `php.ini`-তে add:

```ini
extension=php_pdo_sqlsrv_83_ts_x64.dll
extension=php_sqlsrv_83_ts_x64.dll
```

(আপনার PHP version অনুযায়ী file name বদলাবে)

### Step 2: Database create

SQL Server Management Studio (SSMS) বা sqlcmd দিয়ে:

```sql
CREATE DATABASE AciHealthcare;
```

বা existing backup restore করতে চাইলে:

```sql
RESTORE DATABASE AciHealthcare
FROM DISK = 'D:\path\to\AciHealthcare.Bak'
WITH MOVE 'AciHealthcare' TO 'D:\sqldata\AciHealthcare.mdf',
     MOVE 'AciHealthcare_log' TO 'D:\sqldata\AciHealthcare_log.ldf';
```

### Step 3: `.env` configure

MySQL block কে comment করে এই block uncomment করুন:

```env
# DB_CONNECTION=mysql ... (comment out)

DB_CONNECTION=sqlsrv
DB_HOST=127.0.0.1
DB_PORT=1433
DB_DATABASE=AciHealthcare
DB_USERNAME=sa
DB_PASSWORD=your_password
DB_TRUST_SERVER_CERT=true
DB_ENCRYPT=false
```

### Step 4: Migrate

```bash
php artisan migrate
```

> **Note:** যদি existing DB থেকে restore করেন, তাহলে `php artisan migrate` চালানোর দরকার নেই। শুধু new tables যোগ করতে চাইলে চালান।

---

## 📦 Option 3: SQLite (Zero-config, ছোট test/dev এর জন্য)

### Step 1: PHP extension verify

```bash
php -m | grep -i pdo_sqlite
```

WAMP-এ default থাকে।

### Step 2: SQLite file create

```bash
# File already created in this repo at database/database.sqlite
# যদি না থাকে তাহলে:
touch database/database.sqlite
```

Windows PowerShell:
```powershell
New-Item -ItemType File -Path "database\database.sqlite" -Force
```

### Step 3: `.env` configure

MySQL block comment out করে:

```env
DB_CONNECTION=sqlite
DB_DATABASE=
DB_FOREIGN_KEYS=true
```

`DB_DATABASE` খালি রাখলে automatically `database/database.sqlite` use হবে।

Absolute path use করতে চাইলে:
```env
DB_DATABASE=D:/wamp64/www/HealthCare/acihc_new/database/database.sqlite
```

### Step 4: Migrate

```bash
php artisan migrate
```

> **Note:** SQLite-এ rollback (`migrate:rollback`) limited — আমাদের `sync_columns` migration-এর `down()` method-এ multiple `dropColumn` আছে যা SQLite-এ doctrine/dbal ছাড়া fail করে। যদি SQLite-এ rollback করতে চান:
> ```bash
> composer require doctrine/dbal
> ```

---

## 🔄 Switching Between Databases

DB switch করার সময়:

```bash
# 1. .env-এ DB_CONNECTION block change করুন

# 2. Cache clear
php artisan config:clear
php artisan cache:clear

# 3. Migrate
php artisan migrate
```

---

## 🧪 Testing DB Connection

DB connection test করতে:

```bash
php artisan tinker
```

```php
DB::connection()->getPdo();   // exception না throw হলে connected
DB::connection()->getDatabaseName();  // current DB name
```

---

## 📊 Cross-Database Compatibility Notes

এই project যে features ব্যবহার করে সেগুলো তিন DB-তেই কাজ করে:

| Feature | MySQL | MSSQL | SQLite |
|---------|-------|-------|--------|
| `bigIncrements()` / `id()` | ✅ BIGINT AUTO_INCREMENT | ✅ BIGINT IDENTITY | ✅ INTEGER PK |
| `string(N)` | ✅ VARCHAR | ✅ NVARCHAR | ✅ TEXT |
| `text()` / `longText()` | ✅ TEXT/LONGTEXT | ✅ NVARCHAR(MAX) | ✅ TEXT |
| `json()` | ✅ JSON | ✅ NVARCHAR(MAX) | ✅ TEXT |
| `dateTime()` / `timestamps()` | ✅ DATETIME | ✅ DATETIME | ✅ TEXT |
| `useCurrent()` | ✅ DEFAULT CURRENT_TIMESTAMP | ✅ DEFAULT GETDATE() | ✅ DEFAULT CURRENT_TIMESTAMP |
| `unsignedBigInteger()` | ✅ BIGINT UNSIGNED | ⚠️ BIGINT (no unsigned) | ⚠️ INTEGER (no unsigned) |
| `->after()` (column position) | ✅ supports | ⚠️ ignored (column appended) | ⚠️ ignored |

**Code-level compatibility:**
- কোনো raw MySQL function (`GROUP_CONCAT`, `DATE_FORMAT` etc.) use করা হয়নি
- সব aggregations Laravel collections দিয়ে handle হয়
- Eloquent ORM-এর সবকিছু DB-agnostic

---

## ⚠️ Common Issues

### "could not find driver"
PHP-এ DB extension load নেই। `php.ini`-তে:
- MySQL: `extension=pdo_mysql`
- MSSQL: `extension=pdo_sqlsrv` + `extension=sqlsrv`
- SQLite: `extension=pdo_sqlite`

### "SQLSTATE[HY000] [1045] Access denied"
Username/password wrong, বা MySQL user-এর DB access নেই।

### "SQLSTATE[28000]" (MSSQL)
SQL Server authentication mode "SQL Server and Windows" enabled কিনা check করুন।

### "Database file ... does not exist" (SQLite)
`database/database.sqlite` file নেই। Create করুন (Step 2 দেখুন)।

### Migration fails with "Specified key was too long"
MySQL old version। `app/Providers/AppServiceProvider.php`-এ:
```php
use Illuminate\Support\Facades\Schema;
public function boot() {
    Schema::defaultStringLength(191);
}
```

---

## 🧹 Reset Everything

সব table delete করে fresh start:

```bash
php artisan migrate:fresh
```

⚠️ এটা সব data wipe করে দেয়।

---

## 📝 Default Login (after seeders, if any)

```
Email: admin@admin.com
Password: password
```

(Seed না থাকলে manually create করুন phpMyAdmin/SSMS দিয়ে)
