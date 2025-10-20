<?php

namespace Tests\Unit;

use App\Models\Pedido;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListarPedidosTest extends TestCase
{
    use RefreshDatabase;

    public function test_um_usuario_nao_autenticado_nao_pode_listar_pedidos(): void
    {
        $response = $this->getJson('/api/pedidos');
        $response->assertUnauthorized();
    }

    public function test_um_usuario_autenticado_pode_listar_apenas_os_seus_proprios_pedidos(): void
    {
        /** @var \App\Models\Usuario $usuario */
        $usuario = Usuario::factory()->create();

        $meusPedidos = Pedido::factory()->count(3)->create([
            'id_usuario' => $usuario->id
        ]);

        $outroUsuario = Usuario::factory()->create();

        $pedidosDoOutroUsuario = Pedido::factory()->count(2)->create([
            'id_usuario' => $outroUsuario->id
        ]);

        $response = $this->actingAs($usuario, 'api')
            ->getJson('/api/pedidos');

        $response->assertOk();

        $response->assertJsonCount(3);


        $response->assertJsonFragment(['id' => $meusPedidos[0]->id]);
        $response->assertJsonFragment(['id' => $meusPedidos[1]->id]);
        $response->assertJsonFragment(['id' => $meusPedidos[2]->id]);

        $response->assertJsonMissing(['id' => $pedidosDoOutroUsuario[0]->id]);
        $response->assertJsonMissing(['id' => $pedidosDoOutroUsuario[1]->id]);
    }
}
