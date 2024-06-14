<?php

namespace Database\Factories;

use App\Models\RecipeStuffs;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Board>
 */
class RecipeStuffsFactory extends Factory
{
    // protected $model = RecipeStuffs::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1 years'); // -1년 ~ 현재 랜덤 날짜 획득
        return [
            'recipe_board_id' => $this->faker->numberBetween(2, 10),
            'stuff' => $this->faker->realText(rand(10, 15)),
            'stuff_gram' => $this->faker->numberBetween(1, 200),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
