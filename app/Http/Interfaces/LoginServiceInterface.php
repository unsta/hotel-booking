<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

interface LoginServiceInterface
{
    public function createToken(string $email, string $password): string;
}
