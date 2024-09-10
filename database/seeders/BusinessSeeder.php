<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Business;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Business::create([
            'title' => 'Noteworthy technology acquisitions 2021',
            'description' => 'Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.',
            'image_path' => 'assets/business/BCA.png',
        ]);

        Business::create([
            'title' => 'Another notable acquisition',
            'description' => 'Details about another major acquisition in the tech industry.',
            'image_path' => 'assets/business/BRI.png',
        ]);

        Business::create([
            'title' => 'A third notable acquisition',
            'description' => 'More information about key acquisitions.',
            'image_path' => 'assets/business/Apple.jpg',
        ]);
    }
}
