<?php

declare(strict_types=1);

namespace Feature\Controllers;

use App\Models\Room;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowRoomControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $endpoint;
    private array $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->endpoint = 'api/show-room/';
        $this->headers = ['Accept' => 'application/json'];

        CarbonImmutable::setTestNow('2024-06-13');
    }

    public function testInvokeEntityNotFoundException(): void
    {
        $nonExistingRoomId = 12345;
        $expectedExceptionMessage = ['message' => 'No query results for model [App\\Models\\Room]'];

        $this->getJson($this->endpoint . $nonExistingRoomId, $this->headers)
            ->assertStatus(404)
            ->assertJson($expectedExceptionMessage);
    }

    public function testInvoke(): void
    {
        $expectedJsonStructure = [
            'data' => [
                'number',
                'type',
                'price_per_night',
                'status',
            ]
        ];

        $roomId = Room::factory()->create()->id;

        $this->getJson($this->endpoint . $roomId, $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure($expectedJsonStructure);
    }
}
