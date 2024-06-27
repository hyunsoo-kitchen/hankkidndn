<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\image>
 */
class BoardImagesFactory extends Factory
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
            'board_id' => $this->faker->numberBetween(1, 500),
            'img_path' => '/img/cat'.rand(1,3).'.jpg',
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
