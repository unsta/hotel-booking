<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\{Booking, Customer, Room};
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_id' => Room::factory(),
            'customer_id' => Customer::factory(),
            'check_in_date' => CarbonImmutable::now()->addDay(),
            'check_out_date' => CarbonImmutable::now()->addDays(3),
            'total_price' => 10000
        ];
    }
}
