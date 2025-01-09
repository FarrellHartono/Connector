<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethods;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethods::create([
            'business_id' => 1, 
            'type' => 'Virtual Banking',
            'details' => 'Account Number: VB-123456',
        ]);

        PaymentMethods::create([
            'business_id' => 1, 
            'type' => 'Virtual Banking',
            'details' => 'Account Number: TB-123456',
        ]);

        PaymentMethods::create([
            'business_id' => 1,
            'type' => 'Gopay',
            'details' => 'Gopay ID: GP-123456',
        ]);

        PaymentMethods::create([
            'business_id' => 2, // Assuming 'Bali Retreat' has an ID of 2
            'type' => 'Bank Transfer',
            'details' => 'Account Number: BT-654321',
        ]);
    }
}
