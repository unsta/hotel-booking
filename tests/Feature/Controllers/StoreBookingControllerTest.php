<?php

declare(strict_types=1);

namespace Feature\Controllers;

use App\Models\{Booking, Customer, Room};
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\{DatabaseMigrations, WithoutMiddleware};
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class StoreBookingControllerTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseMigrations;

    private string $endpoint;
    private array $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->endpoint = 'api/store-booking';
        $this->headers = ['Accept' => 'application/json'];

        CarbonImmutable::setTestNow('2024-06-13');
    }

    #[DataProvider('validateRequestDataProvider')]
    public function testInvokeWithValidationException(
        bool $createRoom,
        bool $createCustomer,
        array $payload,
        array $expectedResponse
    ): void {
        if ($createRoom) {
            Room::factory()->create();
        }

        if ($createCustomer) {
            Customer::factory()->create();
        }

        $this->postJson($this->endpoint, $payload, $this->headers)
            ->assertStatus(422)
            ->assertJson($expectedResponse);
    }

    public function testInvokeWithRoomAvailabilityException(): void
    {
        Booking::factory()->create([
            'check_in_date' => "2024-07-16",
            'check_out_date' => "2024-07-20",
        ]);

        $expectedResponse = ['message' => 'The room is not available for the selected period'];

        $payload = [
            'room_id' => 1,
            'customer_id' => 1,
            'check_in_date' => "2024-07-17",
            'check_out_date' => "2024-07-21",
        ];

        $this->postJson($this->endpoint, $payload, $this->headers)
            ->assertStatus(422)
            ->assertJson($expectedResponse);
    }

    #[DataProvider('dataProvider')]
    public function testInvoke(
        bool $createRoom,
        bool $createCustomer,
        int $roomPricePerNight,
        string $roomType,
        array $payload,
        array $expectedJsonStructure,
        array $expectedBookingDbData
    ): void {
        if ($createRoom) {
            Room::factory()->create([
                'type' => $roomType,
                'price_per_night' => $roomPricePerNight
            ]);
        }

        if ($createCustomer) {
            Customer::factory()->create();
        }

        $this->postJson($this->endpoint, $payload, $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure($expectedJsonStructure);

        $this->assertDatabaseHas('bookings', $expectedBookingDbData);
    }

    public static function validateRequestDataProvider(): array
    {
        return [
            'Empty payload' => [
                'createRoom' => false,
                'createCustomer' => false,
                'payload' => [],
                'expectedResponse' => [
                    'message' => 'The room id field is required. (and 3 more errors)',
                    'errors' => [
                        'room_id' => [
                            'The room id field is required.'
                        ],
                        'customer_id' => [
                            'The customer id field is required.'
                        ],
                        'check_in_date' => [
                            'The check in date field is required.'
                        ],
                        'check_out_date' => [
                            'The check out date field is required.'
                        ],
                    ]
                ],
            ],
            'Non-existing room_id & customer_id' => [
                'createRoom' => false,
                'createCustomer' => false,
                'payload' => [
                    'room_id' => 1,
                    'customer_id' => 1,
                    'check_in_date' => "2025-01-17",
                    'check_out_date' => "2025-01-19",
                ],
                'expectedResponse' => [
                    'message' => 'The selected room id is invalid. (and 1 more error)',
                    'errors' => [
                        'room_id' => [
                            'The selected room id is invalid.'
                        ],
                        'customer_id' => [
                            'The selected customer id is invalid.'
                        ],
                    ]
                ],
            ],
            'Invalid date range' => [
                'createRoom' => true,
                'createCustomer' => true,
                'payload' => [
                    'room_id' => 1,
                    'customer_id' => 1,
                    'check_in_date' => "2023-01-17",
                    'check_out_date' => "2023-01-17",
                ],
                'expectedResponse' => [
                    'message' => 'The check in date field must be a date after tomorrow. (and 1 more error)',
                    'errors' => [
                        'check_in_date' => [
                            'The check in date field must be a date after tomorrow.'
                        ],
                        'check_out_date' => [
                            'The check out date field must be a date after check in date.'
                        ],
                    ]
                ],
            ],
            'Invalid date format' => [
                'createRoom' => true,
                'createCustomer' => true,
                'payload' => [
                    'room_id' => 1,
                    'customer_id' => 1,
                    'check_in_date' => "01-17-2025",
                    'check_out_date' => "01-19-2025",
                ],
                'expectedResponse' => [
                    'message' => 'The check in date field must match the format Y-m-d. (and 5 more errors)',
                    'errors' => [
                        'check_in_date' => [
                            'The check in date field must match the format Y-m-d.',
                            'The check in date field must be a date after tomorrow.',
                            'The check in date field must be a date before +1 year.',
                        ],
                        'check_out_date' => [
                            'The check out date field must match the format Y-m-d.',
                            'The check out date field must be a date after check in date.',
                            'The check out date field must be a date before +1 year.',
                        ],
                    ]
                ],
            ],
        ];
    }

    public static function dataProvider(): array
    {
        return [
            'Booking for 3 nights' => [
                'createRoom' => true,
                'createCustomer' => true,
                'roomPricePerNight' => 5000,
                'roomType' => 'single room',
                'payload' => [
                    'room_id' => 1,
                    'customer_id' => 1,
                    'check_in_date' => "2024-07-17",
                    'check_out_date' => "2024-07-20",
                ],
                'expectedJsonStructure' => [
                    'status',
                    'message',
                ],
                'expectedBookingDbData' => [
                    'room_id' => 1,
                    'customer_id' => 1,
                    'check_in_date' => "2024-07-17",
                    'check_out_date' => "2024-07-20",
                    'total_price' => 15000,
                ],
            ]
        ];
    }
}
