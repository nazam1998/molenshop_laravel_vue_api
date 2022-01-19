<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponser;


    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Mot de passe ou email invalides', 401);
        }

        return response()->json([
            'status' => 200,
            'data' => [
                'type' => 'bearer',
                'token' => $request->user()->createToken('API Token')->plainTextToken
            ],
            'message' => "Vous avez été connecté avec succès"
        ]);
    }

    public function logout(Request $request)
    {
        Auth::user()->currentAccessToken()->delete();
        return response()->json(['msg' => 'Vous avez été déconnecté avec succès']);
    }
}
