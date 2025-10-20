<?php

namespace App\Notifications;

use App\Http\Resources\PedidoResource;
use App\Models\Pedido;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PedidoAprovadoNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $pedido;

    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'pedido_id' => $this->pedido->id,
            'mensagem' => "O seu pedido com destino a '{$this->pedido->destino}' foi aprovado!",
            'nome_cliente' => $this->pedido->nome_cliente,
            'status' => ucfirst($this->pedido->status),
            'data' => now()->toFormattedDateString(),
        ];
    }
}
