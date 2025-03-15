<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $permissons = [
            [
                'name' => 'DashboardController@index',
                'display_name' => 'View Dashboard',
                'description' => 'Dashboard'
            ],
            [
                'name' => 'ProfileController@index',
                'display_name' => 'View Profile',
                'description' => 'Profile'
            ],
            [
                'name' => 'ProfileController@update',
                'display_name' => 'Update Role',
                'description' => 'Profile'
            ],
            [
                'name' => 'RoleController@index',
                'display_name' => 'View Role',
                'description' => 'Role'
            ],
            [
                'name' => 'RoleController@create',
                'display_name' => 'Create Role',
                'description' => 'Role'
            ],
            [
                'name' => 'RoleController@store',
                'display_name' => 'Store Role',
                'description' => 'Role'
            ],
            [
                'name' => 'RoleController@edit',
                'display_name' => 'Edit Role',
                'description' => 'Role'
            ],
            [
                'name' => 'RoleController@update',
                'display_name' => 'Update Role',
                'description' => 'Role'
            ],
            [
                'name' => 'RoleController@delete',
                'display_name' => 'Delete Role',
                'description' => 'Role'
            ],
            [
                'name' => 'UserController@index',
                'display_name' => 'View User',
                'description' => 'User'
            ],
            [
                'name' => 'UserController@store',
                'display_name' => 'Create User',
                'description' => 'User'
            ],
            [
                'name' => 'UserController@edit',
                'display_name' => 'Edit User',
                'description' => 'User'
            ],
            [
                'name' => 'UserController@update',
                'display_name' => 'Update User',
                'description' => 'User'
            ],
            [
                'name' => 'UserController@delete',
                'display_name' => 'Delete User',
                'description' => 'User'
            ],
            [
                'name' => 'PermissionController@index',
                'display_name' => 'View Permission',
                'description' => 'Permission'
            ],
            [
                'name' => 'PermissionController@store',
                'display_name' => 'Create Permission',
                'description' => 'Permission'
            ],
            [
                'name' => 'PermissionController@edit',
                'display_name' => 'Edit Permission',
                'description' => 'Permission'
            ],
            [
                'name' => 'PermissionController@update',
                'display_name' => 'Update Permission',
                'description' => 'Permission'
            ],
            [
                'name' => 'PermissionController@delete',
                'display_name' => 'Delete Permission',
                'description' => 'Permission'
            ],
            [
                'name' => 'ActivityLogController@index',
                'display_name' => 'View Activity',
                'description' => 'Activity'
            ],
            [
                'name' => 'SettingsController@index',
                'display_name' => 'View Settings',
                'description' => 'Settings'
            ],
            [
                'name' => 'SettingsController@update',
                'display_name' => 'Update Settings',
                'description' => 'Settings'
            ],
            [
                'name' => 'SettingsController@cache',
                'display_name' => 'Cache Clear',
                'description' => 'Settings'
            ],
            [
                'name' => 'SettingsController@updatePasswordForm',
                'display_name' => 'Edit Password',
                'description' => 'Settings'
            ],
            [
                'name' => 'SettingsController@updatePassword',
                'display_name' => 'Update Password',
                'description' => 'Settings'
            ],
            [
                'name' => 'ManufacturerController@index',
                'display_name' => 'View Manufacturer',
                'description' => 'Manufacturer'
            ],
            [
                'name' => 'ManufacturerController@create',
                'display_name' => 'Create Manufacturer',
                'description' => 'Manufacturer'
            ],
            [
                'name' => 'ManufacturerController@store',
                'display_name' => 'Store Manufacturer',
                'description' => 'Manufacturer'
            ],
            [
                'name' => 'ManufacturerController@edit',
                'display_name' => 'Edit Manufacturer',
                'description' => 'Manufacturer'
            ],
            [
                'name' => 'ManufacturerController@update',
                'display_name' => 'Update Manufacturer',
                'description' => 'Manufacturer'
            ],
            [
                'name' => 'ManufacturerController@delete',
                'display_name' => 'Delete Manufacturer',
                'description' => 'Manufacturer'
            ],
            [
                'name' => 'MarketController@index',
                'display_name' => 'View Market',
                'description' => 'Market'
            ],
            [
                'name' => 'MarketController@create',
                'display_name' => 'Create Market',
                'description' => 'Market'
            ],
            [
                'name' => 'MarketController@store',
                'display_name' => 'Store Market',
                'description' => 'Market'
            ],
            [
                'name' => 'MarketController@edit',
                'display_name' => 'Edit Market',
                'description' => 'Market'
            ],
            [
                'name' => 'MarketController@update',
                'display_name' => 'Update Market',
                'description' => 'Market'
            ],
            [
                'name' => 'MarketController@delete',
                'display_name' => 'Delete Market',
                'description' => 'Market'
            ],
            [
                'name' => 'StudyController@index',
                'display_name' => 'View StudyType',
                'description' => 'StudyType'
            ],
            [
                'name' => 'StudyController@create',
                'display_name' => 'Create StudyType',
                'description' => 'StudyType'
            ],
            [
                'name' => 'StudyController@store',
                'display_name' => 'Store StudyType',
                'description' => 'StudyType'
            ],
            [
                'name' => 'StudyController@edit',
                'display_name' => 'Edit StudyType',
                'description' => 'StudyType'
            ],
            [
                'name' => 'StudyController@update',
                'display_name' => 'Update StudyType',
                'description' => 'StudyType'
            ],
            [
                'name' => 'StudyController@delete',
                'display_name' => 'Delete StudyType',
                'description' => 'StudyType'
            ],
            [
                'name' => 'ConditionController@index',
                'display_name' => 'View Condition',
                'description' => 'Condition'
            ],
            [
                'name' => 'ConditionController@create',
                'display_name' => 'Create Condition',
                'description' => 'Condition'
            ],
            [
                'name' => 'ConditionController@store',
                'display_name' => 'Store Condition',
                'description' => 'Condition'
            ],
            [
                'name' => 'ConditionController@edit',
                'display_name' => 'Edit Condition',
                'description' => 'Condition'
            ],
            [
                'name' => 'ConditionController@update',
                'display_name' => 'Update Condition',
                'description' => 'Condition'
            ],
            [
                'name' => 'ConditionController@delete',
                'display_name' => 'Delete Condition',
                'description' => 'Condition'
            ],
            [
                'name' => 'ApiController@index',
                'display_name' => 'View Api Details',
                'description' => 'ApiDetails'
            ],
            [
                'name' => 'ApiController@create',
                'display_name' => 'Create Api Details',
                'description' => 'ApiDetails'
            ],
            [
                'name' => 'ApiController@store',
                'display_name' => 'Store Api Details',
                'description' => 'ApiDetails'
            ],
            [
                'name' => 'ApiController@edit',
                'display_name' => 'Edit Api Details',
                'description' => 'ApiDetails'
            ],
            [
                'name' => 'ApiController@update',
                'display_name' => 'Update Api Details',
                'description' => 'ApiDetails'
            ],
            [
                'name' => 'ApiController@delete',
                'display_name' => 'Delete Api Details',
                'description' => 'ApiDetails'
            ],
            [
                'name' => 'ProductController@index',
                'display_name' => 'View Product',
                'description' => 'Product'
            ],
            [
                'name' => 'ProductController@create',
                'display_name' => 'Create Product',
                'description' => 'Product'
            ],
            [
                'name' => 'ProductController@store',
                'display_name' => 'Store Product',
                'description' => 'Product'
            ],
            [
                'name' => 'ProductController@edit',
                'display_name' => 'Edit Product',
                'description' => 'Product'
            ],
            [
                'name' => 'ProductController@update',
                'display_name' => 'Update Product',
                'description' => 'Product'
            ],
            [
                'name' => 'ProductController@delete',
                'display_name' => 'Delete Product',
                'description' => 'Product'
            ],
            [
                'name' => 'PackagingController@index',
                'display_name' => 'View Packaging',
                'description' => 'Packaging'
            ],
            [
                'name' => 'PackagingController@create',
                'display_name' => 'Create Packaging',
                'description' => 'Packaging'
            ],
            [
                'name' => 'PackagingController@store',
                'display_name' => 'Store Packaging',
                'description' => 'Packaging'
            ],
            [
                'name' => 'PackagingController@edit',
                'display_name' => 'Edit Packaging',
                'description' => 'Packaging'
            ],
            [
                'name' => 'PackagingController@update',
                'display_name' => 'Update Packaging',
                'description' => 'Packaging'
            ],
            [
                'name' => 'PackagingController@delete',
                'display_name' => 'Delete Packaging',
                'description' => 'Packaging'
            ],
            [
                'name' => 'ContainerController@index',
                'display_name' => 'View Container',
                'description' => 'Container'
            ],
            [
                'name' => 'ContainerController@create',
                'display_name' => 'Create Container',
                'description' => 'Container'
            ],
            [
                'name' => 'ContainerController@store',
                'display_name' => 'Store Container',
                'description' => 'Container'
            ],
            [
                'name' => 'ContainerController@edit',
                'display_name' => 'Edit Container',
                'description' => 'Container'
            ],
            [
                'name' => 'ContainerController@update',
                'display_name' => 'Update Container',
                'description' => 'Container'
            ],
            [
                'name' => 'ContainerController@delete',
                'display_name' => 'Delete Container',
                'description' => 'Container'
            ],
            [
                'name' => 'TestController@index',
                'display_name' => 'View Test',
                'description' => 'Test'
            ],
            [
                'name' => 'TestController@create',
                'display_name' => 'Create Test',
                'description' => 'Test'
            ],
            [
                'name' => 'TestController@store',
                'display_name' => 'Store Test',
                'description' => 'Test'
            ],
            [
                'name' => 'TestController@edit',
                'display_name' => 'Edit Test',
                'description' => 'Test'
            ],
            [
                'name' => 'TestController@update',
                'display_name' => 'Update Test',
                'description' => 'Test'
            ],
            [
                'name' => 'TestController@delete',
                'display_name' => 'Delete Test',
                'description' => 'Test'
            ],
            [
                'name' => 'PackController@index',
                'display_name' => 'View Pack',
                'description' => 'Pack'
            ],
            [
                'name' => 'PackController@create',
                'display_name' => 'Create Pack',
                'description' => 'Pack'
            ],
            [
                'name' => 'PackController@store',
                'display_name' => 'Store Pack',
                'description' => 'Pack'
            ],
            [
                'name' => 'PackController@edit',
                'display_name' => 'Edit Pack',
                'description' => 'Pack'
            ],
            [
                'name' => 'PackController@update',
                'display_name' => 'Update Pack',
                'description' => 'Pack'
            ],
            [
                'name' => 'PackController@delete',
                'display_name' => 'Delete Pack',
                'description' => 'Pack'
            ],
        ];

        foreach ($permissons as $key => $value) {

            $permission = Permission::create([
                            'name' => $value['name'],
                            'display_name' => $value['display_name'],
                            'description' => $value['description']
                        ]);

            User::first()->attachPermission($permission);
        }
    }
}
