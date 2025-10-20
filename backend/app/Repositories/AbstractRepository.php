<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AbstractRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $pedido = $this->find($id);
        if ($pedido === null) return null;
        $pedido->update($data);
        return $pedido;
    }

    public function delete($id)
    {
        $pedido = $this->find($id);
        if ($pedido === null) return null;
        return $pedido->delete();
    }

    public function filtro(array $filtro = [])
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
        return $query->orderBy('created_at', 'desc')->get();
    }
}
