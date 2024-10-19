<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Interfaces\LoginServiceInterface;
use App\Http\Repositories\LoginRepository;
use Carbon\CarbonImmutable;

readonly class LoginService implements LoginServiceInterface
{
    public function __construct(public LoginRepository $repository)
    {
    }

    public function createToken(string $email, string $password): string
    {
        $user = $this->repository->getUser($email, $password);

        $user->tokens()->delete();

        return $user->createToken('token-name', ['*'], CarbonImmutable::now()->addHour())->plainTextToken;
    }
}
