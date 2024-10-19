<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use App\Models\User;

interface LoginRepositoryInterface
{
    public function getUser(string $email, string $password): User;
}
