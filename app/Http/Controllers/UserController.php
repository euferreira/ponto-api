<?php

namespace App\Http\Controllers;

use App\Http\Domain\Usuarios\Contracts\IUserUsecase;

class UserController extends Controller
{
    private IUserUsecase $userUsecase;

    public function __construct(IUserUsecase $userUsecase)
    {
        $this->userUsecase = $userUsecase;
    }

    public function create(): array
    {
        $this->validate(request(), [
            'nome' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|min:6',
        ]);

        return $this->userUsecase->create(request()->all());
    }
}
