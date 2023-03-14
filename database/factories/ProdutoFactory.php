<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categoria;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name($gender = null),
            'descricao' => $this->faker->text($maxNbChars = 2000),
            'preco' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 500, $max = 4000),
            'quantidade' => $this->faker->numberBetween($min = 1, $max = 500),
            'imagem' => $this->faker->imageUrl(640, 480, 'animals', true),
            'categoria_id' => $this->faker->numberBetween(1, Categoria::count())
        ];
    }
}
