<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\CarbonImmutable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bookings')->insert([
            [
                'room_id' => 1,
                'customer_id' => 1,
                'check_in_date' => CarbonImmutable::createFromFormat('Y-m-d', '2024-06-12'),
                'check_out_date' => CarbonImmutable::createFromFormat('Y-m-d', '2024-06-20'),
                'total_price' => 45000,
                'created_at' => CarbonImmutable::now()
            ],
            [
                'room_id' => 3,
                'customer_id' => 1,
                'check_in_date' => CarbonImmutable::createFromFormat('Y-m-d', '2024-08-01'),
                'check_out_date' => CarbonImmutable::createFromFormat('Y-m-d', '2024-08-05'),
                'total_price' => 30000,
                'created_at' => CarbonImmutable::now()
            ],
        ]);
    }
}
