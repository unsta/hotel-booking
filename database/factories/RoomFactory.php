<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\RoomStatus;
use App\Enums\RoomType;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => fake()->unique()->numerify(),
            'type' => fake()->randomElement(RoomType::values()),
            'price_per_night' => 5000,
            'status' => fake()->randomElement(RoomStatus::values())
        ];
    }
}
