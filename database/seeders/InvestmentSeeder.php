<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Investment;

class InvestmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Investment::create([
            'user_id' => '3',
            'business_id' => '2',
            'payment_method_id' => '1',
            'amount' => '500000',
            'status' => '1', // Status untuk accept atau deny.
            'deposit_date'=> '2025-01-06 14:54:34',
        ]);
    }
}
