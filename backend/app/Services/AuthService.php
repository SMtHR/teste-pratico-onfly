<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function autenticar(array $credenciais)
    {
        $token = Auth::attempt($credenciais);
        return $token;
    }

    public function registrar(array $credenciais): JsonResponse
    {
        $usuario = $this->authRepository->create($credenciais);

        $token = Auth::login($usuario);

        return response()->json([
            'message' => 'Usuário registrado com sucesso',
            'usuario' => $usuario,
            'access_token' => $token,
            'expires_in' => Auth::factory()->getTTL() * 60,
        ], 201);
    }
}