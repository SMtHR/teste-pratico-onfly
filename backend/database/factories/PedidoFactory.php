<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    protected $model = Pedido::class;

    public function definition(): array
    {
        $dataIda = fake()->dateTimeBetween('+1 week', '+1 month');
        $dataVolta = fake()->dateTimeBetween(
            (clone $dataIda)->modify('+3 days'),
            (clone $dataIda)->modify('+2 weeks')
        );

        return [
            'nome_cliente' => fake()->name(),
            'destino' => fake()->city() . '/' . fake()->stateAbbr(),
            'dt_ida' => $dataIda,
            'dt_volta' => $dataVolta,

            'status' => fake()->randomElement(['solicitado', 'aprovado', 'cancelado']),

            'id_usuario' => Usuario::factory(),
        ];
    }
}