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
            'password' => Hash::make('12345678'),
            'phone_number' => '12345678',
            'dob' => '2000/01/01',
            'isAdmin' => true,
        ]);
        User::create([
            'name'=> 'Farrell',
            'email' => 'farrell@gmail.com',
            'password' => Hash::make('12345678'),
            'phone_number' => '081223555823',
            'dob' => '2003/05/08',
            'isAdmin' => false,
        ]);
        User::create([
            'name'=> 'Chris',
            'email' => 'chris@gmail.com',
            'password' => Hash::make('12345678'),
            'phone_number' => '081223555823',
            'dob' => '2003/05/08',
            'isAdmin' => false,
        ]);
        User::create([
            'name'=> 'Ricky',
            'email' => 'ricky@gmail.com',
            'password' => Hash::make('12345678'),
            'phone_number' => '081223555823',
            'dob' => '2003/05/08',
            'isAdmin' => false,
        ]);
        
        User::create([
            'name' => 'Alice Johnson',
            'email' => 'alice@gmail.com',
            'password' => Hash::make('12345678'),
            'phone_number' => '081234567890',
            'dob' => '2002/03/15',
            'isAdmin' => false,
        ]);

        User::create([
            'name' => 'Bob Smith',
            'email' => 'bob@gmail.com',
            'password' => Hash::make('12345678'),
            'phone_number' => '081234567891',
            'dob' => '2001/07/22',
            'isAdmin' => false,
        ]);

        User::create([
            'name' => 'Clara Davis',
            'email' => 'clara@gmail.com',
            'password' => Hash::make('12345678'),
            'phone_number' => '081234567892',
            'dob' => '2000/11/30',
            'isAdmin' => false,
        ]);

        User::create([
            'name' => 'David Brown',
            'email' => 'david@gmail.com',
            'password' => Hash::make('12345678'),
            'phone_number' => '081234567893',
            'dob' => '2001/06/14',
            'isAdmin' => false,
        ]);

        User::create([
            'name' => 'Emma Wilson',
            'email' => 'emma@gmail.com',
            'password' => Hash::make('12345678'),
            'phone_number' => '081234567894',
            'dob' => '2002/01/10',
            'isAdmin' => false,
        ]);
    }
}
