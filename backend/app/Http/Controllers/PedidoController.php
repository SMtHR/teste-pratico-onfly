<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pedido\AtualizarPedidoRequest;
use App\Http\Requests\Pedido\CriarPedidoRequest;
use App\Http\Resources\PedidoResource;
use App\Notifications\PedidoAprovadoNotification;
use App\Notifications\PedidoCanceladoNotification;
use App\Services\PedidoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    protected $pedidoService;

    public function __construct(PedidoService $pedidoService)
    {
        $this->pedidoService = $pedidoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filtros = $request->only([
            'status',
            'destino',
            'dt_inicial',
            'dt_final',
            'dt_ida',
            'dt_volta',
        ]);

        $usuario = Auth::user();
        if ($usuario->role !== 'admin') {
            $pedidos = $this->pedidoService->listarPedidosDoUsuario($usuario, $filtros);
            return response()->json(PedidoResource::collection($pedidos), 200);
        }
        $pedidos = $this->pedidoService->all($filtros);
        return response()->json(PedidoResource::collection($pedidos), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CriarPedidoRequest $request)
    {
        $dados = $request->validated();
        $pedido = $this->pedidoService->create($dados);
        return response()->json([
            'message' => 'Pedido criado com sucesso!',
            'pedido' => new PedidoResource($pedido),
        ], 201);;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $usuario = Auth::user();
        if ($usuario->role !== 'admin') {
            $pedido = $this->pedidoService->findPorIdEUsuario($id, $usuario);
            if (!$pedido) return response()->json(['message' => 'Pedido não encontrado'], 404);
            return response()->json(new PedidoResource($pedido), 200);
        }
        $pedido = $this->pedidoService->find($id);
        if (!$pedido) return response()->json(['message' => 'Pedido não encontrado'], 404);
        return response()->json(new PedidoResource($pedido), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AtualizarPedidoRequest $request, string $id)
    {
        $dados = $request->validated();
        $pedido = $this->pedidoService->find($id);
        if ($pedido === null) return response()->json(['message' => 'Pedido não encontrado'], 404);
        if ($pedido->status === 'aprovado' && $request['status'] === 'cancelado') {
            return response()->json(['message' => 'O pedido não pode ser cancelado após aprovação'], 403);
        }
        $pedidoAtualizado = $this->pedidoService->update($pedido, $dados);
        return response()->json(new PedidoResource($pedidoAtualizado), 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function aprovarPedido(AtualizarPedidoRequest $request, string $id)
    {
        $pedido = $this->pedidoService->find($id);
        if ($pedido === null) return response()->json(['message' => 'Pedido não encontrado'], 404);
        if ($pedido->status === 'aprovado') return response()->json(['message' => 'Este pedido já foi aprovado'], 403);

        $pedidoAtualizado = $this->pedidoService->aprovarPedido($id);

        $usuario = $pedidoAtualizado->usuario;
        $usuario->notify(new PedidoAprovadoNotification($pedidoAtualizado));
        return response()->json([
            'message' => 'Pedido aprovado com sucesso!',
            'pedido' => $pedidoAtualizado
        ], 201);
    }

    public function cancelarPedido(AtualizarPedidoRequest $request, string $id)
    {
        $pedido = $this->pedidoService->find($id);
        if ($pedido === null) return response()->json(['message' => 'Pedido não encontrado'], 404);
        if ($pedido->status === 'cancelado') return response()->json(['message' => 'Este pedido já foi cancelado'], 403);
        if ($pedido->status === 'aprovado') return response()->json(['message' => 'O pedido não pode ser cancelado após aprovação'], 403);

        $pedidoAtualizado = $this->pedidoService->cancelarPedido($id);

        $usuario = $pedidoAtualizado->usuario;
        $usuario->notify(new PedidoCanceladoNotification($pedidoAtualizado));
        return response()->json([
            'message' => 'Pedido cancelado com sucesso!',
            'pedido' => $pedidoAtualizado
        ], 201);

        return $response;
    }
}
