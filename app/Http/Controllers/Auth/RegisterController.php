<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
       $user = User::create($request->validated());

       $token = $user->createToken('authToken')->plainTextToken;

      $response = [
        'user' => $user,
        'token' => $token
      ];

      return response($response,201);
    }
}

