<?php

namespace App\Http\Requests\Pedido;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AtualizarPedidoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $usuario = Auth::user();
        return $usuario->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'destino' => 'sometimes|required|string|max:255',
            'dt_ida' => 'sometimes|required|date',
            'dt_volta' => 'nullable|date|after_or_equal:dt_ida',
            'status' => 'sometimes|required|string|in:solicitado,aprovado,cancelado',
        ];
    }
}
