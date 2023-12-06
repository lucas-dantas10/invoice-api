<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Info(title="My First API", version="0.1")
     * @OA\Get(
     *     tags={"users"},
     *     summary="Returns a list of users",
     *     description="Returns a object of users",
     *     path="/api/v1/users",
     *     @OA\Response(response="200", description="A list with users"),
     * ),
    */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * @OA\Get(
     *     tags={"users"},
     *     summary="Returns a user especific",
     *     description="Returns a object of users",
     *     path="/api/v1/users/{user_id}",
     *     @OA\Response(response="200", description="A user especific"),
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
