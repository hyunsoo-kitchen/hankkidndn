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
            '',
            '한끼든든 제휴이벤트',
            '조리도구 할인 이벤트',
            '신규회원을 위한 무료배송이벤트',
        ];
        $index = rand(0, 4);
        $num = rand(1, 3);
        return [
            'admin_id' => 1,
            'title' => $titles[$num],
            'thumb_img_path' => '/img/'.$num.'썸네일.jpg',
            'img_path' => '/img/event'.$num.'.jpg',
            'start_date' => '2024-07-07',
            'end_date' => '2024-08-07',
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
