<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        
        $faker = Faker::create();

        for ($i=1; $i < 3 ; $i++) { 
            $user = new User;
            $user->name = $i == 1 ? 'Admin' : 'Staff';
            $user->email = $i == 1 ? 'admin@demo.com' : 'staff@demo.com';
            $user->password = bcrypt('123456');
            $user->created_at = now();
            $user->save();
        }  
    }
}
