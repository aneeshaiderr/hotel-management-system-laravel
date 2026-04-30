<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        Hotel::updateOrCreate(
            ['hotel_name' => 'Grand Palace'],
            [
                'address' => '123 Luxury Ave, New York, NY',
                'contact_no' => '123-456-7890',
            ]
        );

        Hotel::updateOrCreate(
            ['hotel_name' => 'Sea Breeze Resort'],
            [
                'address' => '456 Ocean View, Miami, FL',
                'contact_no' => '987-654-3210',
            ]
        );

        Hotel::updateOrCreate(
            ['hotel_name' => 'Mountain Retreat'],
            [
                'address' => '789 Pine Ridge, Aspen, CO',
                'contact_no' => '555-010-9988',
            ]
        );

        Hotel::updateOrCreate(
            ['hotel_name' => 'City Central Inn'],
            [
                'address' => '101 Main St, Chicago, IL',
                'contact_no' => '312-555-0011',
            ]
        );
    }
}
