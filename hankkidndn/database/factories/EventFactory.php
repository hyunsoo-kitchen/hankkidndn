<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\events>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1 years');
        $titles = [
            '첫 번째 포스트 제목',
            '두 번째 포스트 제목',
            '세 번째 포스트 제목',
            '네 번째 포스트 제목',
            '다섯 번째 포스트 제목',
        ];
        $index = rand(0, 4);
        return [
            'admin_id' => 1,
            'title' => $titles[$index],
            'thumb_img_path' => '/img/'.rand(1,2).'썸네일.jpg',
            'img_path' => '/img/event.'.rand(1,2).'.jpg',
            'start_date' => '2024-07-07',
            'end_date' => '2024-08-07',
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
