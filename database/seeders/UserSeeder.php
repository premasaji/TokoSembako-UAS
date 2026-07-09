<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@kelontong.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Pak Kasir',
            'email' => 'kasir@kelontong.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
    }
}