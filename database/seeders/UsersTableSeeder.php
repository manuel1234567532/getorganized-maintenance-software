<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //admin
        $admin = User::create([
            'username' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'update_password' => '1',
            'user_type' => 'Administrator',
            'avatar' => 'Image/HB03HH4irw9Jt8ns1704144339.jpg',
        ]);
    }
}