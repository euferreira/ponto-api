<?php

namespace App\Http\Domain\Token\Contracts;

interface ITokenRepository
{
    public function buildToken(array $payload, $expiresIn = 2): string;
}
