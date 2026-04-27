<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Hotel>
 */
class HotelFactory extends Factory
{
    protected $model = Hotel::class;

    public function definition(): array
    {
        return [
            'hotel_name' => $this->faker->company() . ' Hotel',
            'address' => $this->faker->address(),
            'contact_no' => $this->faker->numerify('03#########'),
        ];
    }
}
