<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class RegularUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
        ];

        if (Schema::hasColumn('users', 'role')) {
            $data['role'] = 'user';
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
