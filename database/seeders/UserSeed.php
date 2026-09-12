<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'jana',
            'email' => 'jana@gmail.com',
            'password' => Hash::make('123456789'),
            'type' => 'user',
            'phone' => '1234567891',
            'qr_code' => '1',
        ]);
        User::create([
            'name' => 'salma',
            'email' => 'salma@gmail.com',
            'password' => Hash::make('123456789'),
            'type' => 'user',
            'phone' => '1234567899',
            'qr_code' => '12',
        ]);
        User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456789'),
            'type' => 'user',
            'phone' => '123456789',
            'qr_code' => '123456789',
        ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456789'),
            'type' => 'admin',
            'phone' => '1234567890',
            'qr_code' => '1234567890',
        ]);
        User::create([
            'name' => 'abdo',
            'email' => 'abdo@gmail.com',
            'password' => Hash::make('123456789'),
            'type' => 'admin',
            'phone' => '12345678905',
            'qr_code' => '123',
        ]);
    }
}
