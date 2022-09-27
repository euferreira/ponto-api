<?php

namespace App\Http\Controllers;

use App\Http\Domain\Auth\Contracts\IAuthUsecase;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    private IAuthUsecase $authUsecase;

    public function __construct(IAuthUsecase $authUsecase)
    {
        $this->authUsecase = $authUsecase;
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     operationId="login",
     *     tags={"Auth"},
     *     summary="Login",4
     *     description="Login",
     *     @OA\RequestBody(
     *     required=true,
     *     @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *   ),
     *     @OA\Response(
     *     response=200,
     *     description="Success",
     *  ),
     *     @OA\Response(
     *     response=400,
     *     description="Bad Request",
     *  ),
     * )
     */
    public function create(): array
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        return $this->authUsecase->create(request()->all());
    }
}
