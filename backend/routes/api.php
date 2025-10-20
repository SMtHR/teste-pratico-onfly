<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificacaoController;
use App\Http\Controllers\PedidoController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('registrar', [AuthController::class, 'registrar']);

Route::middleware('auth')->group(function () {
    Route::apiResource('pedidos', PedidoController::class);
    Route::post('pedidos/{id}/aprovar', [PedidoController::class, 'aprovarPedido']);
    Route::post('pedidos/{id}/cancelar', [PedidoController::class, 'cancelarPedido']);

    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('notificacoes', [NotificacaoController::class, 'listarNotificacoes']);
    Route::post('notificacoes/{uuid}/lida', [NotificacaoController::class, 'marcarComoLida']);
    Route::post('notificacoes/lidas', [NotificacaoController::class, 'marcarTodasComoLidas']);
});
