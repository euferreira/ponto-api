<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Laravel API", version="0.1")
 * @OA\Server(url="http://localhost:8000")
 */
abstract class Controller extends BaseController
{
    public abstract function create(): array;
}
