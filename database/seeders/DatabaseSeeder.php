<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
// use role and permission
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'food-list',
            'food-list-active',
            'food-create',
            'food-edit',
            'food-delete',
            'order-list',
            'order-list-active',
            'order-create',
            'order-edit',
            'order-delete',
            'add-order-item',
            'remove-order-item',
            'change-order-status',
            'table-list',
            'table-create',
            'table-edit',
            'table-delete',
            'table-status',
            'payment-process',
            'dashboard',
            // report
            'report-list',
            'report-list-active',
            'report-create',
            'report-edit',
            'report-delete',
            'report-status',
            'report-download',
            'report-print',

        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $roles = [
            'admin',
            'waiter',
            'cashier',
        ];

        foreach ($roles as $role) {
            $role = Role::create(['name' => $role]);
        }

        // role admin has all permissions
        $role = Role::findByName('admin');
        $role->syncPermissions(Permission::all());

        // Waiters can only enter items in the menu list with a status of "Ready" only.
        $role = Role::findByName('waiter');
        $role->syncPermissions([
            'category-list',
            'food-list-active',
            'order-list-active',
            'order-create',
            'add-order-item',
            'remove-order-item',
            'table-list',
            'dashboard',
        ]);

        // Cashiers can only enter items in the menu list with a status of "Ready" only.
        $role = Role::findByName('cashier');
        $role->syncPermissions([
            'order-list-active',
            'order-edit',
            'table-list',
            'table-status',
            'payment-process',
            'dashboard',
            'payment-process',
            'change-order-status',
        ]);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('admin');

        $user = User::create([
            'name' => 'Waiter',
            'email' => 'waiter@waiter.com',
            'username' => 'waiter',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('waiter');

        $user = User::create([
            'name' => 'Cashier',
            'email' => 'cashier@cashier.com',
            'username' => 'cashier',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('cashier');


    }
}
