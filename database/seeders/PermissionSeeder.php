<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create-role',
            'edit-role',
            'delete-role',
            'create-user',
            'edit-user',
            'delete-user',
            'create-cow',
            'edit-cow',
            'delete-cow',
            'create-medicine',
            'edit-medicine',
            'delete-medicine',
            'create-breed',
            'edit-breed',
            'delete-breed',
            'create-milk',
            'edit-milk',
            'delete-milk',
            'create-cowbirth',
            'edit-cowbirth',
            'delete-cowbirth',
            'create-supplier',
            'edit-supplier',
            'delete-supplier',
            'create-paymentmethod',
            'edit-paymentmethod',
            'delete-paymentmethod',
            'create-customer',
            'edit-customer',
            'delete-customer',
            'create-product',
            'edit-product',
            'delete-product',
            'create-purchases',
            'edit-purchases',
            'delete-purchases',
            'create-sales',
            'edit-sales',
            'delete-sales',
            'create-expenses',
            'edit-expenses',
            'delete-expenses',
            'create-account',
            'edit-account',
            'delete-account',
            'create-cowexpenses',
            'edit-cowexpenses',
            'delete-cowexpenses',
        ];

        // Looping and Inserting Array's Permissions into Permission Table
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
