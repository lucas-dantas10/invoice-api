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
     *     tags={"login"},
     *     summary="Loga user and return a token",
     *     description="Loga User",
     *     path="/api/v1/login",
     *     @OA\Response(response="200", description="Authorized"),
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

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->response('Token Revoked', 200);
    }
}
