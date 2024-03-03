<?php

namespace Database\Seeders;

use App\Models\ProfileData;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678')
        ]);
        ProfileData::create([
            'user_id' => $admin->id
        ]);
        $adminRole = Role::where('name', 'admin')->first();
        DB::table('model_has_roles')->insert([
            'role_id' => $adminRole->id,
            'model_type' => User::class,
            'model_id' => $admin->id
        ]);
    }
}