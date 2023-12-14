<?php

namespace App\Http\Controllers;

use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// 3|663xhy8hFvJbTPVsZalFQgAxsXRP2bNMOt8jxvud5a60940c -> invoice
// 4|O6NsHUhTv4eCnv0BvsbULHyOzvZsFLUGCSWkbYCtd3a28eac -> user
class AuthController extends Controller
{
    use HttpResponses;


    /**
     * @OA\Post(
     *     tags={"auth"},
     *     summary="Sign in",
     *     description="Login by email and password",
     *     path="/api/v1/login",
     *     @OA\RequestBody(
 *          description="Pass a user credential",
 *          required=true,
 *          @OA\JsonContent(
 *              required={"email", "password"},
 *              @OA\Property(property="email", type="string", example="mackenzie91@example.com"),
 *              @OA\Property(property="password", type="string", format="password", example="password"),
 *          )
     *    ),
     *     @OA\Response(
     *      response="200", 
     *      description="Authorized",
     *     ),
     *     @OA\Response(
     *      response="403", 
     *      description="Not Authorized",
     *      @OA\JsonContent(
     *          @OA\Property(property="user", type="object", ref="#/components/schemas/User"),
     *      )
     *     )
     * ),
    */
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return $this->response('Authorized', 200, [
                'token' => $request->user()->createToken('invoice')->plainTextToken,
            ]);
        }

        return $this->error('Not Authorized', 403);
    }


    /**
     * @OA\Post(
     * path="/api/v1/logout",
     * security={ {"bearerAuth": {} }},
     * summary="Logout",
     * description="Logout of user",
     * operationId="authLogout",
     * tags={"auth"},
     * @OA\Response(
     *    response=200,
     *    description="Token revoked"
     *     ),
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->response('Token Revoked', 200);
    }
}
