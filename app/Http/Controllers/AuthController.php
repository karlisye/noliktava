<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
  public function register(Request $request): JsonResponse
  {
    $credentials = $request->validate([
      'name' => 'required|string|min:3|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()]
    ]);

    $user = User::create([
      'name' => $credentials['name'],
      'email' => $credentials['email'],
      'password' => Hash::make($credentials['password']),
    ]);

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
      'user' => $user,
      'token' => $token
    ]);
  }

  public function login(Request $request): JsonResponse
  {
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required|string',
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
      return response()->json([
        'message' => 'Invalid credentials',
      ], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
      'user' => $user,
      'token' => $token,
    ]);
  }

  public function logout(Request $request): JsonResponse
  {
    $request->user()->currentAccessToken()->delete();

    return response()->json([
      'message' => 'Logged out successfully',
    ]);
  }
}
