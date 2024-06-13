<?php

declare(strict_types=1);

namespace Feature\Controllers;

use App\Models\Room;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\{DatabaseMigrations, WithoutMiddleware};
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class StoreRoomControllerTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseMigrations;

    private string $endpoint;
    private array $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->endpoint = 'api/store-room';
        $this->headers = ['Accept' => 'application/json'];

        CarbonImmutable::setTestNow('2024-06-13');
    }

    #[DataProvider('validateRequestDataProvider')]
    public function testInvokeWithValidationException(
        bool $createRoom,
        array $payload,
        array $expectedResponse
    ): void {
        if ($createRoom) {
            Room::factory()->create(['number' => $payload['number']]);
        }

        $this->postJson($this->endpoint, $payload, $this->headers)
            ->assertStatus(422)
            ->assertJson($expectedResponse);
    }

    #[DataProvider('dataProvider')]
    public function testInvoke(
        array $payload,
        array $expectedJsonStructure,
        array $expectedRoomDbData
    ): void {
        $this->postJson($this->endpoint, $payload, $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure($expectedJsonStructure);

        $this->assertDatabaseHas('rooms', $expectedRoomDbData);
    }

    public static function validateRequestDataProvider(): array
    {
        return [
            'Empty payload' => [
                'createRoom' => false,
                'payload' => [],
                'expectedResponse' => [
                    'message' => 'The number field is required. (and 3 more errors)',
                    'errors' => [
                        'number' => [
                            'The number field is required.'
                        ],
                        'type' => [
                            'The type field is required.'
                        ],
                        'price_per_night' => [
                            'The price per night field is required.'
                        ],
                        'status' => [
                            'The status field is required.'
                        ],
                    ]
                ],
            ],
            'Existing room number' => [
                'createRoom' => true,
                'payload' => [
                    'number' => 'A31',
                    'type' => 'suite',
                    'price_per_night' => 5000,
                    'status' => 'vacant',
                ],
                'expectedResponse' => [
                    'message' => 'The number has already been taken.',
                    'errors' => [
                        'number' => [
                            'The number has already been taken.'
                        ],
                    ]
                ],
            ],
            'Invalid room type' => [
                'createRoom' => false,
                'payload' => [
                    'number' => 'A32',
                    'type' => 'suite-test',
                    'price_per_night' => 5000,
                    'status' => 'vacant',
                ],
                'expectedResponse' => [
                    'message' => 'The selected type is invalid.',
                    'errors' => [
                        'type' => [
                            'The selected type is invalid.'
                        ],
                    ]
                ],
            ],
            'Invalid room status' => [
                'createRoom' => false,
                'payload' => [
                    'number' => 'A32',
                    'type' => 'suite',
                    'price_per_night' => 5000,
                    'status' => 'vacant-test',
                ],
                'expectedResponse' => [
                    'message' => 'The selected status is invalid.',
                    'errors' => [
                        'status' => [
                            'The selected status is invalid.'
                        ],
                    ]
                ],
            ],
        ];
    }

    public static function dataProvider(): array
    {
        return [
            'Valid room' => [
                'payload' => [
                    'number' => 'A32',
                    'type' => 'suite',
                    'price_per_night' => 5000,
                    'status' => 'vacant',
                ],
                'expectedJsonStructure' => [
                    'status',
                    'message',
                ],
                'expectedRoomDbData' => [
                    'number' => 'A32',
                    'type' => 'suite',
                    'price_per_night' => 5000,
                    'status' => 'vacant',
                ],
            ]
        ];
    }
}
