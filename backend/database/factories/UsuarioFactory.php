<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * O model correspondente a esta factory.
     *
     * @var string
     */
    protected $model = Usuario::class;

    /**
     * A senha atual usada pela factory.
     * Usar uma propriedade estática evita que a senha seja re-hashada
     * a cada vez que a factory é chamada dentro de um único processo.
     */
    protected static ?string $password;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Gera um nome de usuário falso, como "Dr. John Doe"
            'usuario' => fake()->name(),

            // Gera um e-mail único e seguro (ex: john.doe@example.com)
            'email' => fake()->unique()->safeEmail(),

            // Define a senha padrão como 'password'
            // O cast 'hashed' no seu model cuidará de hashear isso automaticamente
            'password' => static::$password ??= 'password',

            // Define um 'role' padrão. Você pode sobrescrever isso nos seus testes.
            'role' => 'user',
        ];
    }

    /**
     * Indica que o e-mail do modelo deve ser não verificado.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
