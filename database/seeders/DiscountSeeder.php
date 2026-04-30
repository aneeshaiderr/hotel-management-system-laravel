<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Discount;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        Discount::updateOrCreate(
            ['discount_name' => 'Summer Sale'],
            [
                'discount_type' => 'percentage',
                'value' => 15.00,
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
                'status' => 'active',
            ]
        );

        Discount::updateOrCreate(
            ['discount_name' => 'Welcome Bonus'],
            [
                'discount_type' => 'flat',
                'value' => 50.00,
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'status' => 'active',
            ]
        );

        Discount::updateOrCreate(
            ['discount_name' => 'Winter Special'],
            [
                'discount_type' => 'percentage',
                'value' => 20.00,
                'start_date' => now()->addMonths(6),
                'end_date' => now()->addMonths(9),
                'status' => 'active',
            ]
        );

        Discount::updateOrCreate(
            ['discount_name' => 'Flash Deal'],
            [
                'discount_type' => 'percentage',
                'value' => 40.00,
                'start_date' => now(),
                'end_date' => now()->addDays(2),
                'status' => 'inactive',
            ]
        );
    }
}
