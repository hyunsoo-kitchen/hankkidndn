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
        $user_id = $this->faker->numberBetween(1, 9); // 1부터 50까지의 랜덤한 사용자 ID
        // $boards_type_id = $this->faker->numberBetween(1, 5); // 1부터 5까지의 랜덤한 게시판 타입 ID
        $titles = [
            '밀푀유나베 레시피',
            '샤브샤브 레시피',
            '타코야끼 레시피',
            '야끼소바 덮밥 레시피',
            '텐동 레시피',
            // '마라탕 레시피',
            // '깐풍기 레시피',
            // '사골 떡국 레시피',
            // '비빔밥 레시피',
            // '목살 김치찜 레시피',
        ];
    
        $contents = [
            '다양한 해산물과 신선한 파가 어우러진 바삭한 해물파전! 밀가루 반죽에 해산물과 파를 듬뿍 넣어 지글지글 부치면 고소하고 풍미 가득한 전이 완성됩니다. 간장 양념장에 찍어 먹으면 더욱 맛있어요.',
            '싱싱한 해산물이 들어간 담백하고 시원한 해물 칼국수! 쫄깃한 칼국수 면발과 해물 육수가 어우러져 깊고 깔끔한 맛을 자랑합니다. 아삭한 채소와 함께 먹으면 더욱 풍성한 맛을 느낄 수 있어요.',
            '매콤한 고추장 양념에 잘 볶아진 돼지고기를 뜨거운 밥 위에 얹어 먹는 제육덮밥! 양파와 대파 등 채소가 돼지고기와 어우러져 씹는 맛이 좋고, 매콤달콤한 양념이 입맛을 돋웁니다.',
            '아삭아삭한 열무로 만든 시원하고 상큼한 열무 김치! 고춧가루, 마늘, 생강 등으로 양념한 열무를 절여 발효시키면 여름철 별미로 손색없는 시원한 김치가 완성됩니다.',
            '부드러운 순두부와 각종 해산물, 고기가 어우러진 얼큰한 순두부찌개! 고춧가루와 고추기름이 들어가 매콤한 국물이 일품이며, 부드러운 순두부가 속을 따뜻하게 해줍니다.',
            '두툼한 소갈비와 각종 채소가 듬뿍 들어간 진한 소갈비 전골! 갈비를 푹 고아낸 국물에 채소와 버섯을 넣어 깊고 진한 맛을 자랑합니다. 담백하면서도 풍성한 맛이 일품입니다.',
            '신선한 성게와 부드러운 미역이 만나 깊고 풍미 있는 성게 미역국! 바다 향이 가득한 성게가 국물에 녹아들어, 깔끔하면서도 진한 맛을 자랑합니다. 건강에 좋은 미역과 함께 먹으면 더욱 좋습니다.',
            '진한 사골 국물에 쫄깃한 떡이 어우러진 따뜻한 사골 떡국! 사골을 오랜 시간 고아낸 국물이 떡에 스며들어 깊고 진한 맛을 느낄 수 있습니다. 달걀지단과 고명을 올려 더욱 맛있게 즐겨보세요.',
            '다양한 채소와 고기가 어우러진 비빔밥! 신선한 나물과 잘 볶은 고기를 밥 위에 얹고, 매콤한 고추장과 참기름을 곁들여 쓱쓱 비벼 먹으면 다양한 맛을 한 그릇에 담을 수 있습니다.',
            '두툼한 목살과 푹 익은 김치가 어우러진 매콤한 목살 김치찜! 돼지고기 목살을 김치와 함께 푹 찜해 고기가 부드럽고, 매콤한 김치 맛이 고기에 배어들어 맛이 일품입니다.'
        ];

        $youtubes = [
            'https://www.youtube.com/watch?v=O2YSXyxCPDE',
            'https://www.youtube.com/watch?v=FXUKcEjcPF8',
            'https://www.youtube.com/watch?v=spjIN3vPVVY',
            'https://www.youtube.com/watch?v=-KM6v1R6LLs',
            'https://www.youtube.com/watch?v=nj-DjQFEZb0',
            'https://www.youtube.com/watch?v=P-NmcI5C6q8',
            'https://www.youtube.com/watch?v=V8s9VAtvqqs',
            'https://www.youtube.com/watch?v=c4ojM-eytSc',
            'https://www.youtube.com/watch?v=KJAHpWjbB2k',
            'https://www.youtube.com/watch?v=B9k3zTFJ-y0',
        ];

        $thumbnail = [
            '밀푀유나베_1.PNG',
            '샤부샤부_1.PNG',
            '타코야키_1.PNG',
            '야끼소바_1.PNG',
            '텐동_1.PNG',
            // '마라탕_1.PNG',
            // '깐풍기_1.PNG',
            // '사골 떡국_1.jpg',
            // '비빔밥_1.PNG',
            // '목살 김치찜_1.jpg',
        ];

        $index = rand(0, 4);
        
        return [
            'user_id' => $user_id,
            'boards_type_id' => 4,
            'likes_num' => $this->faker->numberBetween(0, 100),
            'title' => $titles[$index],
            'content' => $contents[$index],
            'video_link' => $youtubes[$index],
            'thumbnail' => '/img/'.$thumbnail[$index],
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
