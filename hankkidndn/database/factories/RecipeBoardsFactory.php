<?php

namespace Database\Factories;


use App\Models\RecipeBoards;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Board>
 */
class RecipeBoardsFactory extends Factory
{
    protected $model = RecipeBoards::class;
    

    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1 years'); // -1년 ~ 현재 랜덤 날짜 획득
        $user_id = $this->faker->numberBetween(1, 50); // 1부터 50까지의 랜덤한 사용자 ID
        $boards_type_id = $this->faker->numberBetween(1, 5); // 1부터 5까지의 랜덤한 게시판 타입 ID
        $titles = [
            '해물파전 레시피',
            '해물 칼국수 레시피',
            '제육덮밥 레시피',
            '열무 김치 레시피',
            '순두부찌개 레시피',
            '소갈비 전골 레시피',
            '성게 미역국 레시피',
            '사골 떡국 레시피',
            '비빔밥 레시피',
            '목살 김치찜 레시피',
        ];
    
        $contents = [
            '첫 번째 포스트 내용',
            '두 번째 포스트 내용',
            '세 번째 포스트 내용',
            '네 번째 포스트 내용',
            '다섯 번째 포스트 내용',
        ];
        
        return [
            'user_id' => $user_id,
            'boards_type_id' => 1,
            'likes_num' => $this->faker->numberBetween(0, 100),
            'title' => $this->faker->realText(rand(10, 15)),
            'content' => $this->faker->realText(rand(10, 100)),
            'video_link' => $this->faker->url(),
            'thumbnail' => '/img/순두부찌개_'.rand(1,5).'.png',
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
