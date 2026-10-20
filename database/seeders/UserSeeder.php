<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@indogunapalembang.com',
            'password' => Hash::make('#Palembang0711'),
            'role' => 'admin',
            'phone' => '081234567890',
            'department' => 'IT',
        ]);
    }
}