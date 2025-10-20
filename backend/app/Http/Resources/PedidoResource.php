<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome_cliente' => $this->nome_cliente,
            'destino' => $this->destino,
            'dt_ida' => Carbon::parse($this->dt_ida)->format('d/m/Y'),
            'dt_volta' => Carbon::parse($this->dt_volta)->format('d/m/Y'),
            'status' => ucfirst($this->status),
            'id_usuario' => $this->id_usuario,
        ];
    }
}
