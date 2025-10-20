<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegistrarRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $credenciais = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $token = $this->authService->autenticar($credenciais);
        if (!$token) {
            return response()->json(['message' => 'Credenciais inválidas'], 401);
        }
        $usuario = Auth::user();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'usuario' => $usuario,
        ], 200);
    }

    public function me()
    {
        return response()->json(['usuario' => Auth::user()], 200);
    }

    public function registrar(RegistrarRequest $request)
    {
        $credenciais = $request->validated();

        $response = $this->authService->registrar($credenciais);

        return $response;
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Deslogado com sucesso']);
    }
}
