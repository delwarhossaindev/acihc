<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class BackupDataSeeder extends Seeder
{
    /**
     * Tables in dependency order. JSON files live in database/seeders/data/.
     */
    protected array $tables = [
        // Lookup / master tables
        'roles',
        'permissions',
        'ProtocolStatus',
        'ProtocolApprovalType',
        'Condition',
        'Pack',
        'Container',
        'Packaging',
        'ContainerPackaging',
        'Test',
        'StudyType',
        'StudyTypeDetail',
        'Manufacturer',
        'Market',
        'settings',

        // Users + access control
        'users',
        'role_user',
        'permission_role',
        'permission_user',

        // Polymorphic
        'addresses',
        'images',

        // Product
        'Product',
        'ProductDetail',
        'SkuPack',
        'ApiDetail',
        'ProductAPIDetail',

        // Protocol hierarchy
        'Protocol',
        'ProtocolProductDetail',
        'ProtocolAPIDetail',
        'ProtocolPackagingPack',
        'ProtocolPackPrimary',
        'ProtocolPackSecondary',
        'ProtocolPackTertiary',
        'ProtocolStabilityStudy',
        'ProtocolSkuPack',
        'ProtocolSkuPackContainer',
        'ProtocolTest',
        'ProtocolTestPackBottle',
        'ProtocolSkuUnitPack',
        'PlaceboSkuUnitPack',
        'Placebo',
        'ProtocolPlaceboDetail',
        'ProtocolApprovalTree',
        'ProtocolApprover',
        'ProtocolReviewer',
        'ProtocolHistoryReason',
        'ProtocolVersion',
        'StabilityDesignTitle',

        // Batch
        'Batch',
        'BatchDetails',

        // Sample
        'Sample',
        'SampleReport',
        'SampleReportDetail',
        'SampleApprovalTree',
        'SampleApprover',
        'SampleReviewer',
    ];

    public function run(): void
    {
        $dataDir = database_path('seeders/data');
        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
        } elseif ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');
        } elseif ($driver === 'sqlsrv') {
            DB::statement('EXEC sp_MSforeachtable "ALTER TABLE ? NOCHECK CONSTRAINT ALL"');
        }

        try {
            foreach ($this->tables as $table) {
                $this->seedTable($table, $dataDir);
            }
        } finally {
            if ($driver === 'mysql') {
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            } elseif ($driver === 'sqlite') {
                DB::statement('PRAGMA foreign_keys = ON');
            } elseif ($driver === 'sqlsrv') {
                DB::statement('EXEC sp_MSforeachtable "ALTER TABLE ? WITH CHECK CHECK CONSTRAINT ALL"');
            }
        }
    }

    protected function seedTable(string $table, string $dataDir): void
    {
        $path = $dataDir . DIRECTORY_SEPARATOR . $table . '.json';

        if (! File::exists($path)) {
            $this->command?->warn("Skipping {$table} — no JSON file found");
            return;
        }

        if (! Schema::hasTable($table)) {
            $this->command?->warn("Skipping {$table} — table does not exist");
            return;
        }

        $rows = json_decode(File::get($path), true);

        if (! is_array($rows) || empty($rows)) {
            $this->command?->info("Skipping {$table} — empty data");
            return;
        }

        DB::table($table)->truncate();

        $columns = Schema::getColumnListing($table);
        $filtered = array_map(
            fn ($row) => array_intersect_key($row, array_flip($columns)),
            $rows
        );

        $count = 0;
        foreach (array_chunk($filtered, 200) as $chunk) {
            DB::table($table)->insert($chunk);
            $count += count($chunk);
        }

        $this->command?->info(sprintf('Seeded %-35s %5d rows', $table, $count));
    }
}
