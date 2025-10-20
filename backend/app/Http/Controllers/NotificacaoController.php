<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacaoController extends Controller
{
    public function listarNotificacoes()
    {
        $usuario = Auth::user();
        $notificacoes = $usuario->unreadNotifications;
        return response()->json($notificacoes, 200);
    }

    public function marcarComoLida($uuid)
    {
        $usuario = Auth::user();
        $notificacao = $usuario->notifications->findOrFail($uuid);
        $notificacao->markAsRead();

        return response()->json(['message' => 'Notificação marcada como lida.'], 200);
    }

    public function marcarTodasComoLidas()
    {
        $usuario = Auth::user();
        $usuario->unreadNotifications->markAsRead();
        return response()->json(['message' => 'Todas as notificações foram marcadas como lidas.'], 200);
    }
}