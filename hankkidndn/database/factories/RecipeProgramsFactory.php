<?php

namespace Database\Factories;

use App\Models\RecipePrograms;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Board>
 */
class RecipeProgramsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1 years'); // -1년 ~ 현재 랜덤 날짜 획득
        return [
            'recipe_board_id' => $this->faker->numberBetween(2, 500),
            'img_path' => '/img/순두부찌개_'.rand(1,5).'.png',
            'program_content' => $this->faker->realText(rand(10, 15)),
            'order' => $this->faker->numberBetween(1, 5),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
