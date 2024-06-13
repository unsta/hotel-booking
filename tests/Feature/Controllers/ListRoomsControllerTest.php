<?php

declare(strict_types=1);

namespace Feature\Controllers;

use App\Models\Room;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ListRoomsControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $endpoint;
    private array $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->endpoint = 'api/list-rooms';
        $this->headers = ['Accept' => 'application/json'];

        CarbonImmutable::setTestNow('2024-06-13');
    }

    #[DataProvider('dataProvider')]
    public function testInvoke(bool $createRoom, array $expectedJsonStructure): void
    {
        if ($createRoom) {
            Room::factory()->create();
        }

        $this->getJson($this->endpoint, $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure($expectedJsonStructure);
    }

    public static function dataProvider(): array
    {
        return [
            'No rooms' => [
                'createRoom' => false,
                'expectedJsonStructure' => [
                    'data'
                ]
            ],
            'Has rooms' => [
                'createRoom' => true,
                'expectedJsonStructure' => [
                    'data' => [
                        [
                            'id',
                            'number',
                            'type',
                            'price_per_night',
                            'status',
                            'created_at',
                            'updated_at',
                        ]
                    ]
                ]
            ]
        ];
    }
}
