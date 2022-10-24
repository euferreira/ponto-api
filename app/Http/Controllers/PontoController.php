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
        $agora = new \DateTime('now');
        $agora = $agora->format('Y-m-d H:i:s');

        return $this->pontoUsecase->create([
            'registro' => $agora,
        ]);
    }
}
