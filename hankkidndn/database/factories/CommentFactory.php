<?php

namespace Database\Factories;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1 years'); // -1년 ~ 현재 랜덤 날짜 획득
        $user_id = $this->faker->numberBetween(3, 50); // 1부터 50까지의 랜덤한 사용자 ID
        $boards_id = $this->faker->numberBetween(3, 50); // 1부터 5까지의 랜덤한 게시판 타입 ID
        
        return [
            'user_id' => $user_id,
            'recipe_board_id' => $boards_id,
            'board_id' => $boards_id,
            'cocoment' => $this->faker->numberBetween(1, 20),
            'content' => $this->faker->realText(rand(10, 100)),
            'likes_num' => $this->faker->numberBetween(0, 200),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
