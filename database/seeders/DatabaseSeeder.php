<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database from the AciHealthcare.Bak data dump.
     *
     * Usage:
     *   php artisan db:seed                           # full backup data
     *   php artisan db:seed --class=BackupDataSeeder  # explicit
     *
     * Legacy hand-coded seeders (kept for reference):
     *   php artisan db:seed --class=PermissionSeeder
     *   php artisan db:seed --class=RoleSeeder
     *   php artisan db:seed --class=UserSeeder
     */
    public function run(): void
    {
        $this->call(BackupDataSeeder::class);
    }
}
