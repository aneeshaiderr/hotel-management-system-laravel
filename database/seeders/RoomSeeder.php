<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Hotel;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $hotel = Hotel::first();

        if ($hotel) {
            Room::updateOrCreate(
                ['room_number' => '101'],
                [
                    'hotel_id' => $hotel->id,
                    'floor' => 1,
                    'status' => 'available',
                    'beds' => 1,
                    'max_guests' => 2,
                ]
            );

            Room::updateOrCreate(
                ['room_number' => '201'],
                [
                    'hotel_id' => $hotel->id,
                    'floor' => 2,
                    'status' => 'available',
                    'beds' => 2,
                    'max_guests' => 4,
                ]
            );
        }
    }
}
