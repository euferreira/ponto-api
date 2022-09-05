<?php

namespace App\Http\Controllers;

use App\Http\Domain\Ponto\Contracts\IPontoUsecase;
use Illuminate\Validation\ValidationException;

class PontoController extends Controller
{
    private IPontoUsecase $pontoUsecase;

    public function __construct(IPontoUsecase $pontoUsecase)
    {
        $this->pontoUsecase = $pontoUsecase;
    }

    /**
     * @throws ValidationException
     */
    public function create(): array
    {
        $this->validate(request(), [
            'registro' => 'required',
        ]);

        return $this->pontoUsecase->create(request()->all());
    }
}
