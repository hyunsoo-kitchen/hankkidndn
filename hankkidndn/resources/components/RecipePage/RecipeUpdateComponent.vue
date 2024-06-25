<template>
    <div class="container">
        <h2 class="main_h2">레시피 등록</h2>
        <form id="recipeForm">
            <div class="first_box">
                <div class="section grid_box">
                    <label class="column_1to2 title_font" for="title"><h3>레시피 제목</h3></label>
                    <!-- 게시판 종류랑 썸네일 추가했어요 -->
                    <select name="boards_type_id">
                        <option value="1">한식게시판</option>
                        <option value="2">중식게시판</option>
                        <option value="3">양식게시판</option>
                        <option value="4">일식게시판</option>
                        <option value="5">베이커리게시판</option>
                    </select>
                    <label>
                        <div>썸네일 이미지</div>
                        <input hidden @change="thumbnailImg($event)" name="thumbnail" type="file" accept="image/*" >
                    </label>
                    <img v-if="!thumbnail" :src="store.state.recipeData.thumbnail">
                    <img v-if="thumbnail" :src="thumbnail">
                    <input autocomplete="off" class="column_2to3" type="text" name="title" id="title" placeholder="예) 소고기 무국" :value="store.state.recipeData.title">
                </div>
                <div class="section grid_box">
                    <label class="column_1to2 title_font" for="summary"><h3>요리소개</h3></label>
                    <textarea autocomplete="off" class="column_2to3to" id="content" name="content" placeholder="예) " rows="5">{{ $store.state.recipeData.content }}</textarea>
                </div>
                <div class="section grid_box">
                    <label class="column_1to2 title_font" for="video"><h3>동영상</h3></label>
                    <input :value="store.state.recipeData.video_link" class="column_2to3" type="url" id="video" name="video" placeholder="예) 영상이 youtube에 있다면 주소를 넣어주세요. https://youtu.be/abcd1234"></input>
                </div>
            </div>

            <!-- 재료 추가 -->
            <div class="section">
                <h3>재료 정보</h3>
                <div id="ingredients">
                    <div class="ingredient_row ingredient_box" v-for="(item, index) in $store.state.recipeStuff" :key="index">
                        <input autocomplete="off" class="note_input1 ingredient_content" type="text" v-model="item.stuff" name="stuff[]" placeholder="재료 예)돼지고기">
                        <input autocomplete="off" class="note_input ingredient_content" type="text" name="stuff_gram[]" v-model="item.stuff_gram" placeholder="예)g, ml(단위)">
                        <button v-if="$store.state.recipeStuff.length > 1" @click="removeStuff(index)" class="remove_btn ingredient_content delete_btn" type="button">제거</button>
                    </div>
                </div>
                <button @click="addStuff()" class="add_btn" type="button" id="addIngredient">추가</button>
            </div>

            <!-- 요리 순서 추가 -->
            <div class="cook-list">
                <div class="cook-btn">
                    <h3>요리순서</h3>
                </div>
                <div class="list-input">
                    <button @click="addPrograms()" class="list-btn-remove" type="button">순서 추가</button>
                </div>
                <div class="content_list" v-for="(item, index) in $store.state.recipeProgram" :key="index">
                    <p> Step {{ index + 1 }}</p>
                    <textarea autocomplete="off" class="text-list" :name="'list[]'" id="list" v-model="item.program_content" placeholder="예 ) 소고기를 기름에 두른 팬에" rows="5"></textarea>
                    <img v-if="item.img_path" :src="item.img_path" style="max-width: 200px; margin-bottom: 10px;">
                    <label>
                        <div>이미지 파일</div>
                        <input hidden :name="'file' + (index + 1)" type="file" accept="image/*" @change="programImg($event, index)" >
                    </label>
                    <button v-if="$store.state.recipeProgram.length > 1" @click="removePrograms(index)" class="list-btn-start" type="button">순서 제거</button>
                </div>
                <!-- <input type="hidden" name="maxOrder" :value="$store.state.recipeProgram.length"> -->
            </div>

            <!-- 작성 버튼 -->
            <div class="actions">
                <button @click="$store.dispatch('recipeUpdate', store.state.recipeData.id)" type="button">저장</button>
                <button @click="$router.back()" type="button" id="cancel">취소</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const store = useStore();
const route = useRoute();

const thumbnail = ref();

// 추가 및 제거 함수
function addStuff(){
    store.state.recipeStuff.push({ stuff: '', stuff_gram: '' });
};

function removeStuff(index){
    store.state.recipeStuff.splice(index, 1);
};

function addPrograms(){
    store.state.recipeProgram.push({ program_content: '', img_path: null });
};

function removePrograms(index){
    store.state.recipeProgram.splice(index, 1);
};

// 썸네일 미리보기
function thumbnailImg(e) {
    const file = event.target.files[0];
    if (!file) return;

    const imageUrl = URL.createObjectURL(file);
    thumbnail.value = imageUrl;
}

// 요리과정 이미지 미리보기
function programImg(img, index) {

    const file = img.target.files[0];

    // 취소 누를경우 빈배열 생기는걸 방지
    if (!file) return;

    // 선택한 파일의 URL 생성
    const imageUrl = URL.createObjectURL(file);

    // 이미지 URL을 저장
    store.state.recipeProgram[index].img_path = imageUrl;
}

onBeforeMount(() => {
    store.dispatch('getRecipeUpdate', route.params.id)
})

</script>
<style scoped src="../../css/recipeinsert.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>