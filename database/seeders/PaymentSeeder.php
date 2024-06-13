<?php

declare(strict_types=1);

namespace Database\Seeders;

use Carbon\CarbonImmutable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payments')->insert([
            [
                'booking_id' => 1,
                'amount' => 45000,
                'payment_date' => CarbonImmutable::createFromFormat('Y-m-d H:i:s', '2024-06-10 11:14:34'),
                'status' => 'complete',
                'created_at' => CarbonImmutable::now(),
            ],
            [
                'booking_id' => 2,
                'amount' => 30000,
                'payment_date' => null,
                'status' => 'pending',
                'created_at' => CarbonImmutable::now(),
            ],
        ]);
    }
}
