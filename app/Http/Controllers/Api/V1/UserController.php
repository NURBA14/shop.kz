<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\UserLoginRequest;
use App\Http\Requests\Api\V1\User\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(UserLoginRequest $request)
    {
        $email = $request->validated("email");
        $password = $request->validated("password");
        if(!Auth::guard("web")->attempt(["email" => $email, "password" => $password])){
            return response()->json(["message" => "Incorrect Email or Password"], 401);
        }
        $user = Auth::guard("web")->user();
        $token = $user->createToken("login");
        return response()->json(["token" => $token->plainTextToken]);
    }

    public function register(UserRegisterRequest $request)
    {
        $user = User::create([
            "name" => $request->validated("name"),
            "email" => $request->validated("email"),
            "password" => bcrypt($request->validated("password"))
        ]);
        $token = $user->createToken("login");
        return response()->json([
            "message" => "You are registered",
            "token" => $token->plainTextToken
        ]); 
    }
}
