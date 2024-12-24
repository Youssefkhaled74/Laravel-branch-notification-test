<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'Youssef200212@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'branch_owner',
        ]);

        User::create([
            'name' => 'Branch Owner',
            'email' => 'owner@example.com',
            'password' => Hash::make('password123'),
            'role' => 'branch_owner',
        ]);
    }
}
