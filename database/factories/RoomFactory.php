<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'hotel_id' => Hotel::query()->inRandomOrder()->value('id') ?? Hotel::factory(),
            'room_number' => (string) $this->faker->unique()->numberBetween(100, 999),
            'floor' => $this->faker->numberBetween(1, 10),
            'status' => $this->faker->randomElement(['available', 'occupied', 'maintenance']),
            'beds' => $this->faker->numberBetween(1, 4),
            'max_guests' => $this->faker->numberBetween(1, 8),
        ];
    }
}
