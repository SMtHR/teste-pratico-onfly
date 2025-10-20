<?php

namespace App\Repositories;

use App\Models\Pedido;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PedidoRepository extends AbstractRepository
{
    public function __construct(Pedido $model)
    {
        parent::__construct($model);
    }

    public function listarPedidosDoUsuario(Usuario $usuario, array $filtro = [])
    {
        $pedidos = $this->filtro($filtro);

        return $pedidos->where('id_usuario', $usuario->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function findPorIdEUsuario(string $idPedido, Usuario $usuario)
    {
        return $this->model->where('id', $idPedido)
            ->where('id_usuario', $usuario->id)
            ->first();
    }

    public function filtro(array $filtro = []): Builder
    {
        $query = $this->model->query();

        if (!empty($filtro['status'])) {
            $query->where('status', $filtro['status']);
        }
        if (!empty($filtro['destino'])) {
            $query->where('destino', 'like', '%' . $filtro['destino'] . '%');
        }
        if (!empty($filtro['dt_inicial']) && !empty($filtro['dt_final'])) {
            $query->whereBetween(
                DB::raw('DATE(created_at)'),
                [$filtro['dt_inicial'], $filtro['dt_final']]
            );
        }
        if (!empty($filtro['dt_ida']) && !empty($filtro['dt_volta'])) {
            $query->where(function ($q) use ($filtro) {
                $q->whereBetween('dt_ida', [$filtro['dt_ida'], $filtro['dt_volta']])
                    ->orWhereBetween('dt_volta', [$filtro['dt_ida'], $filtro['dt_volta']]);
            });
        }
        return $query;
    }
}
