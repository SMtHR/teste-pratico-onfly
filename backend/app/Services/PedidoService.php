<?php

namespace App\Services;

use App\Http\Resources\PedidoResource;
use App\Models\Pedido;
use App\Models\Usuario;
use App\Notifications\PedidoAprovadoNotification;
use App\Notifications\PedidoCanceladoNotification;
use App\Repositories\PedidoRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PedidoService
{
    protected $pedidoRepository;

    public function __construct(PedidoRepository $pedidoRepository)
    {
        $this->pedidoRepository = $pedidoRepository;
    }

    public function all(array $filtros = [])
    {
        if (!empty($filtros)) {
            return $this->pedidoRepository->filtro($filtros);
        }

        $pedidos = $this->pedidoRepository->all();
        return $pedidos;
    }

    public function listarPedidosDoUsuario(Usuario $usuario, array $filtros = [])
    {
        $pedidos = $this->pedidoRepository->listarPedidosDoUsuario($usuario, $filtros);
        return $pedidos;
    }

    public function findPorIdEUsuario(string $idPedido, Usuario $usuario): Pedido | null
    {
        $pedido = $this->pedidoRepository->findPorIdEUsuario($idPedido, $usuario);
        if (!$pedido) return null;
        return $pedido;
    }

    public function find($id): Pedido
    {
        $pedido = $this->pedidoRepository->find($id);
        return $pedido;
    }

    public function create(array $data): Pedido
    {
        $pedido = $this->pedidoRepository->create([
            'nome_cliente' => Auth::user()->usuario,
            'destino' => $data['destino'],
            'dt_ida' => $data['dt_ida'],
            'dt_volta' => $data['dt_volta'],
            'status' => 'solicitado',
            'id_usuario' => Auth::id(),
        ]);
        return $pedido;
    }

    public function update($pedido, array $data): Pedido
    {
        $statusAntigo = $pedido->status;

        $pedidoAtualizado = $this->pedidoRepository->update($pedido->id, $data);
        $usuario = $pedidoAtualizado->usuario;

        if ($this->pedidoFoiAprovado($statusAntigo, $pedidoAtualizado)) {
            $usuario->notify(new PedidoAprovadoNotification($pedidoAtualizado));
        }
        if ($this->pedidoFoiCancelado($statusAntigo, $pedidoAtualizado)) {
            $usuario->notify(new PedidoCanceladoNotification($pedidoAtualizado));
        }
        return $pedidoAtualizado;
    }

    public function delete($id)
    {
        return $this->pedidoRepository->delete($id);
    }

    public function aprovarPedido($id): Pedido
    {
        $pedidoAtualizado = $this->pedidoRepository->update($id, ['status' => 'aprovado']);;
        return $pedidoAtualizado;
    }

    public function cancelarPedido($id): Pedido
    {
        $pedidoAtualizado = $this->pedidoRepository->update($id, ['status' => 'cancelado']);
        return $pedidoAtualizado;
    }

    private function pedidoFoiAprovado(string $statusAntigo, Pedido $pedidoAtualizado): bool
    {
        return ($statusAntigo === 'solicitado' || $statusAntigo === 'cancelado') && $pedidoAtualizado->status === 'aprovado';
    }

    private function pedidoFoiCancelado(string $statusAntigo, Pedido $pedidoAtualizado): bool
    {
        return ($statusAntigo === 'solicitado' || $statusAntigo === 'aprovado') && $pedidoAtualizado->status === 'cancelado';
    }
}
