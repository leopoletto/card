<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;

class RegisterUserController extends Controller
{
    public function __invoke(RegisterUserRequest $request): User
    {
        return User::create($request->validated());
    }
}
