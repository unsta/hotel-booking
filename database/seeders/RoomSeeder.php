<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\CarbonImmutable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rooms')->insert([
            [
                'number' => 'A11',
                'type' => 'single room',
                'price_per_night' => 5000,
                'status' => 'occupied',
                'created_at' => CarbonImmutable::now(),
            ],
            [
                'number' => 'A12',
                'type' => 'triple room',
                'price_per_night' => 10000,
                'status' => 'vacant',
                'created_at' => CarbonImmutable::now(),
            ],
            [
                'number' => 'A13',
                'type' => 'double room',
                'price_per_night' => 7500,
                'status' => 'occupied',
                'created_at' => CarbonImmutable::now(),
            ],
            [
                'number' => 'A21',
                'type' => 'king room',
                'price_per_night' => 25000,
                'status' => 'vacant',
                'created_at' => CarbonImmutable::now(),
            ],
        ]);
    }
}
