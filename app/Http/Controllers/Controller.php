<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer"
 *    )
 * @OA\Info(title="Invoice API", 
 * version="1.0.0"),
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
