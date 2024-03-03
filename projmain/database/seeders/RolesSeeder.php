<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                'name' => 'user',
                'guard_name' => 'user',
                'created_at' => date('Y-m-d H:i:s')
            ], [
                'name' => 'admin',
                'guard_name' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}