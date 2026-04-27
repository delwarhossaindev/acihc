<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'display_name' => 'Company Name',
                'key' => 'company_name',
                'value' => 'ACI HEALTHCARE'
            ],
            [
                'display_name' => 'Company Email',
                'key' => 'company_email',
                'value' => 'company@example.com'
            ],
            [
                'display_name' => 'Set Timezone',
                'key' => 'set_timezone',
                'value' => config('app.timezone')
            ]
        ];

        Setting::insert($data);  
    }
}
