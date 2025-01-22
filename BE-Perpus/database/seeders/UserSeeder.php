<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => Str::uuid(),
            'name' => 'Admin User',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'role_id' => DB::table('roles')->where('name', 'owner')->value('id'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'id' => Str::uuid(),
            'name' => 'Regular User',
            'email' => 'user@mail.com',
            'password' => Hash::make('password'),
            'role_id' => DB::table('roles')->where('name', 'user')->value('id'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
