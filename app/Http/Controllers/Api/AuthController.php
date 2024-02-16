<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\error;

class AuthController extends Controller
{
  public function register(Request $request)
  {
      $user = User::create([
          'name' => $request->get('name'),
          'email' => $request->get('email'),
          'password' => Hash::make($request->get('password')),
      ]);
      $token = $user->createToken('Token Name')->plainTextToken;
      return [
          'user' => new UserResource($user),
          'token' => $token,
      ];
  }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = $request->user();


            $user->tokens()
                ->where('name', 'Token Name')
                ->delete();
            $token = $user->createToken('Token Name')->plainTextToken;

            return [
                'token' => $token,
                'user' =>  new UserResource($user),
            ];
        } else {
            return response()->json([
                'message' => 'Неверный email, или пароль'
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logged out']);
        }

        return response()->json(['message' => 'No user to log out']);
    }

}
