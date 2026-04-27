<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $roles = [
            [
                'name' => 'administrator',
                'display_name' => 'Admin',
                'description' => 'Can access all features!'
            ],
            [
                'name' => 'staff',
                'display_name' => 'Staff',
                'description' => 'Can access limited features!'
            ],
        ];
        
        foreach ($roles as $key => $value) {
            $role = Role::create([
                        'name' => $value['name'],
                        'display_name' => $value['display_name'],
                        'description' => $value['description']
                    ]);
            $key == 0 ? 
                User::first()->attachRole($role) :  
                User::find(2)->attachRole($role);
        }
    }
}
