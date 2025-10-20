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
    /**
     * O model correspondente a esta factory.
     *
     * @var string
     */
    protected $model = Pedido::class;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Gera datas de ida e volta lógicas para a viagem
        $dataIda = fake()->dateTimeBetween('+1 week', '+1 month');
        $dataVolta = fake()->dateTimeBetween(
            (clone $dataIda)->modify('+3 days'), // Pelo menos 3 dias de viagem
            (clone $dataIda)->modify('+2 weeks') // Máximo de 2 semanas de viagem
        );

        return [
            'nome_cliente' => fake()->name(),
            'destino' => fake()->city() . '/' . fake()->stateAbbr(),
            'dt_ida' => $dataIda,
            'dt_volta' => $dataVolta,

            // Gera um status aleatório a partir de uma lista provável
            'status' => fake()->randomElement(['solicitado', 'aprovado', 'cancelado']),

            // Define a associação com um usuário.
            // Se nenhum 'id_usuario' for passado, ele criará um novo Usuário
            // automaticamente usando a UsuarioFactory.
            'id_usuario' => Usuario::factory(),
        ];
    }
}
