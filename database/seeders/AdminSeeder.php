<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=> 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345'),
            'phone_number' => '12345',
            'dob' => '2000/01/01',
            'isAdmin' => true,
        ]);
    }
}
