<?php

declare(strict_types=1);

namespace Feature\Controllers;

use App\Models\Customer;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\{DatabaseMigrations, WithoutMiddleware};
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class StoreCustomerControllerTest extends TestCase
{
    use WithoutMiddleware;
    use DatabaseMigrations;

    private string $endpoint;
    private array $headers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->endpoint = 'api/store-customer';
        $this->headers = ['Accept' => 'application/json'];

        CarbonImmutable::setTestNow('2024-06-13');
    }

    #[DataProvider('validateRequestDataProvider')]
    public function testInvokeWithValidationException(
        bool $createCustomer,
        array $payload,
        array $expectedResponse
    ): void {
        if ($createCustomer) {
            Customer::factory()->create(['email' => $payload['email']]);
        }

        $this->postJson($this->endpoint, $payload, $this->headers)
            ->assertStatus(422)
            ->assertJson($expectedResponse);
    }

    #[DataProvider('dataProvider')]
    public function testInvoke(
        array $payload,
        array $expectedJsonStructure,
        array $expectedCustomerDbData
    ): void {
        $this->postJson($this->endpoint, $payload, $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure($expectedJsonStructure);

        $this->assertDatabaseHas('customers', $expectedCustomerDbData);
    }

    public static function validateRequestDataProvider(): array
    {
        return [
            'Empty payload' => [
                'createCustomer' => false,
                'payload' => [],
                'expectedResponse' => [
                    'message' => 'The name field is required. (and 2 more errors)',
                    'errors' => [
                        'name' => [
                            'The name field is required.'
                        ],
                        'email' => [
                            'The email field is required.'
                        ],
                        'phone_number' => [
                            'The phone number field is required.'
                        ],
                    ]
                ],
            ],
            'Existing email' => [
                'createCustomer' => true,
                'payload' => [
                    'name' => 'Jo Jones',
                    'email' => 'JoJones@example.com',
                    'phone_number' => '+35912312332',
                ],
                'expectedResponse' => [
                    'message' => 'The email has already been taken.',
                    'errors' => [
                        'email' => [
                            'The email has already been taken.',
                        ],
                    ]
                ],
            ],
            'Invalid phone (integer)' => [
                'createCustomer' => false,
                'payload' => [
                    'name' => 'Jo Jones',
                    'email' => 'JoJones@example.com',
                    'phone_number' => 12123,
                ],
                'expectedResponse' => [
                    'message' => 'The phone number field must be a string. (and 1 more error)',
                    'errors' => [
                        'phone_number' => [
                            'The phone number field must be a string.',
                            'The phone number field must be at least 8 characters.'
                        ],
                    ]
                ],
            ],
            'Invalid phone (length)' => [
                'createCustomer' => false,
                'payload' => [
                    'name' => 'Jo Jones',
                    'email' => 'JoJones@example.com',
                    'phone_number' => '359',
                ],
                'expectedResponse' => [
                    'message' => 'The phone number field must be at least 8 characters.',
                    'errors' => [
                        'phone_number' => [
                            'The phone number field must be at least 8 characters.'
                        ],
                    ]
                ],
            ],
        ];
    }

    public static function dataProvider(): array
    {
        return [
            'Valid customer' => [
                'payload' => [
                    'name' => 'Jo Jones',
                    'email' => 'JoJones@example.com',
                    'phone_number' => "+35912312323",
                ],
                'expectedJsonStructure' => [
                    'status',
                    'message',
                ],
                'expectedCustomerDbData' => [
                    'name' => 'Jo Jones',
                    'email' => 'JoJones@example.com',
                    'phone_number' => "+35912312323",
                ],
            ]
        ];
    }
}
