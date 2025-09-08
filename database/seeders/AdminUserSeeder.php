<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ];

        // Optional/conditional columns
        if (Schema::hasColumn('users', 'role')) {
            $data['role'] = 'admin';
        }
        if (Schema::hasColumn('users', 'status')) {
            $data['status'] = 'active';
        }
        if (Schema::hasColumn('users', 'email_verified_at')) {
            $data['email_verified_at'] = now();
        }
        if (Schema::hasColumn('users', 'balance')) {
            $data['balance'] = 0;
        }

        User::updateOrCreate(
            ['email' => $data['email']],
            $data
        );
    }
}
