<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'usuario' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= 'password',
            'role' => 'user',
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}