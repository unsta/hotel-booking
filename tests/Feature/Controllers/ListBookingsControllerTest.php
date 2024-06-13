<?php

declare(strict_types=1);

namespace Feature\Controllers;

use App\Models\Booking;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ListBookingsControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $endpoint;
    private array $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->endpoint = 'api/list-bookings';
        $this->headers = ['Accept' => 'application/json'];

        CarbonImmutable::setTestNow('2024-06-13');
    }

    #[DataProvider('dataProvider')]
    public function testInvoke(bool $createBooking, array $expectedResponse): void
    {
        if ($createBooking) {
            Booking::factory()->create();
        }

        $this->getJson($this->endpoint, $this->headers)
            ->assertStatus(200)
            ->assertJson($expectedResponse);
    }

    public static function dataProvider(): array
    {
        return [
            'No bookings' => [
                'createBooking' => false,
                'expectedResponse' => [
                    'data' => []
                ]
            ],
            'Has bookings' => [
                'createBooking' => true,
                'expectedResponse' => [
                    'data' => [
                        [
                            'id' => 1,
                            'room_id' => 1,
                            'customer_id' => 1,
                            'check_in_date' => "2024-06-14",
                            'check_out_date' => "2024-06-16",
                            'total_price' => 10000,
                            'created_at' => '2024-06-13 00:00:00',
                            'updated_at' => '2024-06-13 00:00:00',
                        ]
                    ]
                ]
            ]
        ];
    }
}
