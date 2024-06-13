<?php

declare(strict_types=1);

namespace Feature\Controllers;

use App\Models\Customer;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowCustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    private string $endpoint;
    private array $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->endpoint = 'api/show-customer/';
        $this->headers = ['Accept' => 'application/json'];

        CarbonImmutable::setTestNow('2024-06-13');
    }

    public function testInvokeEntityNotFoundException(): void
    {
        $nonExistingCustomerId = 12345;
        $expectedExceptionMessage = ['message' => 'No query results for model [App\\Models\\Customer]'];

        $this->getJson($this->endpoint . $nonExistingCustomerId, $this->headers)
            ->assertStatus(404)
            ->assertJson($expectedExceptionMessage);
    }

    public function testInvoke(): void
    {
        $expectedJsonStructure = [
            'data' => [
                'id',
                'name',
                'email',
                'phone_number',
            ]
        ];

        $customerId = Customer::factory()->create()->id;

        $this->getJson($this->endpoint . $customerId, $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure($expectedJsonStructure);
    }
}
