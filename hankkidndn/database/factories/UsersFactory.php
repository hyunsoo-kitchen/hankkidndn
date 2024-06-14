<?php

namespace Database\Factories;

use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UsersFactory extends Factory
{
    protected $model = Users::class;

    public function definition()
    {
        $date = $this->faker->dateTimeBetween('-1 years'); // -1년 ~ 현재 랜덤 날짜 획득
        $birth_date = $this->faker->dateTimeBetween('-20 years', '-1 years'); // -20년 ~ -1년 랜덤 날짜 획득
        $phoneNumber = '010-' . mt_rand(1000, 9999) . '-' . mt_rand(1000, 9999);
        $username = $this->faker->unique()->regexify('[A-Za-z0-9]{5,10}');
        $random_postcode = mt_rand(10000, 99999);
        return [
            'u_name' => $this->faker->name,
            'u_id' => $username,
            'u_password' => Hash::make('qwer1234!'), // 비밀번호는 암호화된 기본값 사용
            'u_nickname' => $this->faker->userName,
            'gender' => $this->faker->randomElement([0, 1]), // 0: 남자, 1: 여자
            'u_email' => $this->faker->unique()->safeEmail,
            'u_phone_num' =>$phoneNumber,
            'u_post' => $random_postcode,
            'profile' => '/img/cat'.rand(1,3).'.jpg',
            'u_address' => $this->faker->city,
            'u_detail_address' => $this->faker->address,
            'birth_at' => $birth_date,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
