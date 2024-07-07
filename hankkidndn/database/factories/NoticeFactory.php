<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notice>
 */
class NoticeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1 years'); // -1년 ~ 현재 랜덤 날짜 획득
        $titles = [
            '첫 번째 포스트 제목',
            '두 번째 포스트 제목',
            '세 번째 포스트 제목',
            '네 번째 포스트 제목',
            '다섯 번째 포스트 제목',
        ];
    
        $contents = [
            '첫 번째 포스트 내용',
            '두 번째 포스트 내용',
            '세 번째 포스트 내용',
            '네 번째 포스트 내용',
            '다섯 번째 포스트 내용',
        ];

        $index = rand(0, 4);
        return [
            'admin_id' => 1,
            'title' => $titles[$index],
            'content' => $contents[$index],
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
