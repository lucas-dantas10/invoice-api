<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"users"},
     *     summary="List of users",
     *     description="Returns a list of users",
     *     path="/api/v1/users",
     *     security={ {"bearerAuth": {} }},
     *     @OA\Response(response="200", description="A list with users", @OA\JsonContent()),
     * ),
    */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * @OA\Get(
     *     tags={"users"},
     *     summary="Returns a user",
     *     description="Returns a specific user",
     *     path="/api/v1/users/{user_id}",
     *     security={ {"bearerAuth": {} }},
     *     @OA\Response(response="200", description="A specific user", @OA\JsonContent()),
     *     @OA\Parameter(
     *         name="user_id",
     *         in= "path",
     *         required=true,
     *     ),
     * ),
    */
    public function show(User $user)
    {
        return new UserResource($user);
    }
}
