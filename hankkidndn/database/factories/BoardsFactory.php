<?php

namespace Database\Factories;

use App\Models\Boards;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Boards>
 */
class BoardsFactory extends Factory
{
    protected $model = Boards::class;
    

    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1 years'); // -1년 ~ 현재 랜덤 날짜 획득
        $user_id = $this->faker->numberBetween(1, 50); // 1부터 50까지의 랜덤한 사용자 ID
        $boards_type_id = $this->faker->numberBetween(1, 5); // 1부터 5까지의 랜덤한 게시판 타입 ID
        
        return [
            'user_id' => $user_id,
            'boards_type_id' => $boards_type_id,
            'likes_num' => $this->faker->numberBetween(0, 100),
            'title' => $this->faker->realText(rand(10, 15)),
            'content' => $this->faker->realText(rand(10, 100)),
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
