<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::updateOrCreate(
            ['service_name' => 'Free Wi-Fi'],
            [
                'status' => 'active',
                'price' => 0.00,
            ]
        );

        Service::updateOrCreate(
            ['service_name' => 'Room Service'],
            [
                'status' => 'active',
                'price' => 15.00,
            ]
        );

        Service::updateOrCreate(
            ['service_name' => 'Swimming Pool'],
            [
                'status' => 'active',
                'price' => 5.00,
            ]
        );
    }
}
