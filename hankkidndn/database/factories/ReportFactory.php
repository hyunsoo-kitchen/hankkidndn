<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1 years'); // -1년 ~ 현재 랜덤 날짜 획득
        $user_id = $this->faker->numberBetween(1, 20); // 1부터 50까지의 랜덤한 사용자 ID
        $boards_type_id = $this->faker->numberBetween(1, 7); // 1부터 5까지의 랜덤한 게시판 타입 ID
        $contents = [
            '첫 번째 신고 내용',
            '두 번째 신고 내용',
            '세 번째 신고 내용',
            '네 번째 신고 내용',
            '다섯 번째 신고 내용',
        ];

        $index = rand(0, 4);
        return [
            'user_id' => $user_id,
            'recipe_board_id' => $this->faker->numberBetween(1300, 1450),
            'report_type_id' => $boards_type_id,
            'content' => $contents[$index],
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
