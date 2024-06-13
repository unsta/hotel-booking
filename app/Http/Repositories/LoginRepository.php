<?php

declare(strict_types=1);

namespace App\Http\Repositories;

use App\Http\Exceptions\LoginException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginRepository
{
    public function __construct()
    {
    }

    public function getUser(string $email, string $password): User
    {
        $user = User::where('email', $email)->first();

        if (null === $user || false === Hash::check($password, $user->password)) {
            throw new LoginException();
        }

        return $user;
    }
}
