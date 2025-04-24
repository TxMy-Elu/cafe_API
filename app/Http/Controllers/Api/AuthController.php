<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->headers->set('Accept', 'application/json');

        $request->validate([
            'login' => 'required|string',
            'pwd' => 'required|string',
        ]);

        $user = Users::where('login', $request->login)->first();

        if ($user && Hash::check($request->pwd, $user->pwd)) {
            return response()->json(['token' => $user->token], 200);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function generateToken(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = Users::where('login', $request->login)->first();

        if ($user && Hash::check($request->password, $user->pwd)) {
            $token = bin2hex(random_bytes(32)); // Generate a random token
            $user->token = $token;
            $user->save();

            return response()->json(['token' => $token], 200);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }
}
