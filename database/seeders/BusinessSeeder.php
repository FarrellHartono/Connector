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
            'title' => 'Oishi Japan',
            'description' => 'Oishi Japan specializes in delicious homemade dishes for Japanese occasions, providing a variety of menus including traditional japanese cuisine like sushi, or ramen.',
            'image_path' => '/public/assets/business/Oishi Japan',
            'nominal' => '5000000',
            'phone_number' => '081234567890',
            'address' => 'Jl. Sudirman No. 12, Jakarta',
            'user_id' => '2',
            'status' => '1'
        ]);
        
        Business::create([
            'title' => 'Bakso Goreng Pecenongan',
            'description' => 'Bakso Goreng Pecenongan serves crispy fried meatballs with a savory flavor, perfect as a snack or side dish. Loved by customers across Jakarta.',
            'image_path' => '/public/assets/business/Bakso Goreng Pecenongan',
            'nominal' => '1500000',
            'phone_number' => '082134567890',
            'address' => 'Jl. Pecenongan No. 45, Jakarta',
            'user_id' => '2',
            'status' => '1',
            'current_investment' => '500000',
        ]);
        
        Business::create([
            'title' => 'Kopi Nusantara',
            'description' => 'Kopi Nusantara brings the rich flavors of Indonesian coffee beans to life, offering freshly brewed coffee and a cozy ambiance for coffee enthusiasts.',
            'image_path' => '/public/assets/business/Kopi Nusantara',
            'nominal' => '2000000',
            'phone_number' => '083234567890',
            'address' => 'Jl. Veteran No. 7, Bandung',
            'user_id' => '3',
            'status' => '1'
        ]);
        
        Business::create([
            'title' => 'Warung Makan Ibu Sari',
            'description' => 'A popular choice for locals, Warung Makan Ibu Sari offers affordable and delicious home-style Indonesian dishes, made fresh daily.',
            'image_path' => '/public/assets/business/Warung Makan Ibu Sari',
            'nominal' => '1000000',
            'phone_number' => '081354678901',
            'address' => 'Jl. Diponegoro No. 20, Surabaya',
            'user_id' => '3',
            'status' => '0'
        ]);
        
        Business::create([
            'title' => 'Toko Kue Lezat',
            'description' => 'Toko Kue Lezat offers a wide variety of freshly baked pastries, cakes, and cookies, perfect for celebrations or everyday treats.',
            'image_path' => '/public/assets/business/Toko Kue Lezat',
            'nominal' => '3000000',
            'phone_number' => '082334567891',
            'address' => 'Jl. Merdeka No. 5, Yogyakarta',
            'user_id' => '3',
            'status' => '1'
        ]);
        
        Business::create([
            'title' => 'Laundry Express',
            'description' => 'Laundry Express provides fast and reliable laundry services, ensuring your clothes are fresh and clean within 24 hours.',
            'image_path' => '/public/assets/business/laundry-express',
            'nominal' => '2500000',
            'phone_number' => '085334567891',
            'address' => 'Jl. Kemang Raya No. 18, Bali',
            'user_id' => '4',
            'status' => '2'
        ]);
    }
}
