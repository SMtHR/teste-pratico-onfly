<?php

namespace App\Repositories;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class AuthRepository extends AbstractRepository
{
    public function __construct(Usuario $model)
    {
        parent::__construct($model);
    }

    public function create(array $credenciais)
    {
        $role = Auth::user()?->role === 'admin' && !empty($credenciais['role'])
            ? $credenciais['role']
            : 'user';

        $usuario = $this->model->create([
            'usuario' => $credenciais['usuario'],
            'email' => $credenciais['email'],
            'role' => $role,
            'password' => bcrypt($credenciais['password']),
        ]);
        return $usuario;
    }
}
