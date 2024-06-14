<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
  public function login(AuthLoginRequest $request)
  {
    $user = User::where('email', $request->get('email'))->first();
    if (Hash::check($request->get('password'), $user->password)) {
      return [
        'token' => $user->createToken(time())->plainTextToken,
        'user' => $user
      ];
    }
  }
}
