<?php

namespace App\Http\Controllers;

use App\Http\Domain\Auth\Contracts\IAuthUsecase;

class AuthController extends Controller
{
    private IAuthUsecase $authUsecase;

    public function __construct(IAuthUsecase $authUsecase)
    {
        $this->authUsecase = $authUsecase;
    }

    public function create(): array
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        return $this->authUsecase->create(request()->all());
    }
}
