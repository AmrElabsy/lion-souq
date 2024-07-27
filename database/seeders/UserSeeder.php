<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@email.com',
                'role' => 'admin'
            ],
            [
                'name' => 'Vendor',
                'email' => 'vendor@email.com',
                'role' => 'vendor'
            ],
            [
                'name' => 'User',
                'email' => 'user@email.com',
                'role' => 'user'
            ],
        ];
        
        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'password' => Hash::make('12345678'),
            ]);
        }
    }
}
