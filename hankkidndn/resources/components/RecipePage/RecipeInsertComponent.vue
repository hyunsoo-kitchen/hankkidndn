<template>
    <div class="container">
        <h2 class="main_h2">레시피 등록</h2>
        <form autocomplete="off" id="recipeForm">
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
                    <label class="btn_label">
                        <div>썸네일 이미지</div>
                        <input required hidden @change="thumbnailImg($event)" name="thumbnail" type="file" accept="image/*">
                    </label>
                    <div v-if="thumbnailFlg">썸네일 이미지를 골라주세요.</div>
                    <img v-if="thumbnail" :src="thumbnail" class="img_thumb">
                    <h3>요리제목</h3>
                    <input class="column_2to3" type="text" name="title" id="title" placeholder="예) 소고기 무국">
                    <!-- <div>요리 제목을 입력 해 주세요.</div> -->
                </div>
                <div class="section grid_box">
                    <!-- <label class="column_1to2 title_font" for="content"><h3>요리소개</h3></label> -->
                    <h3>요리소개</h3>
                    <textarea class="column_2to3to" id="content" name="content" placeholder="예) " rows="5"></textarea>
                    <!-- <div>요리 소개를 입력 해 주세요.</div> -->
                </div>
                <div class="section grid_box">
                    <!-- <label class="column_1to2 title_font" for="video"><h3>동영상</h3></label> -->
                    <h3>동영상</h3>
                    <input class="column_2to3" type="text" id="video" name="video" placeholder="예) 영상이 youtube에 있다면 주소를 넣어주세요. https://youtu.be/abcd1234"></input>
                </div>
            </div>

            <!-- 재료 추가 -->
            <div class="section">
                <h3>재료 정보</h3>
                <div id="ingredients">
                    <div class="ingredient_row ingredient_box" v-for="(item, index) in stuffs" :key="index">
                        <input  class="note_input1 ingredient_content" type="text" v-model="item.stuff" name="stuff[]" placeholder="재료 예)돼지고기">
                        <input  class="note_input ingredient_content" type="text" name="stuff_gram[]" v-model="item.stuff_gram" placeholder="예)g, ml(단위)">
                        <button v-if="stuffs.length > 1" @click="removeStuff(index)" class="remove_btn ingredient_content delete_btn" type="button">제거</button>
                    </div>
                </div>
                <button @click="addStuff()" class="add_btn" type="button" id="addIngredient">추가</button>
            </div>

            <!-- 요리 순서 추가 -->
            <div class="cook_list">
                <div class="cook-btn">
                    <h3>요리순서</h3>
                </div>
                <div class="content_list" v-for="(item, index) in programs" :key="index">
                    <p> Step {{ index + 1 }}</p>
                    <textarea  class="text-list" name="list[]" id="list" v-model="item.program" placeholder="예 ) 소고기를 기름에 두른 팬에" rows="5"></textarea>
                    <img v-if="item.previewUrl" :src="item.previewUrl" style="margin-bottom: 10px;" class="img_thumb">
                    <label class="btn_label2">
                        <div>이미지 파일</div>
                        <input hidden name="file[]" type="file" accept="image/*" @change="programImg($event, index)" >
                    </label>
                    <button v-if="programs.length > 1" @click="removePrograms(index)" class="list-btn-start" type="button">순서 제거</button>
                </div>
                <div class="list-input">
                    <button @click="addPrograms()" class="list-btn-remove" type="button">순서 추가</button>
                </div>
            </div>
            <div class="actions">
                <button @click="$store.dispatch('recipeInsert')" type="button">저장</button>
                <!-- <button type="button" id="saveAndShare">저장 후 공개하기</button> -->
                <button @click="$router.back()" type="button" id="cancel">취소</button>
            </div>
        </form>
    </div>
</template>
<script setup>
import { reactive, ref } from 'vue';

// 입력 여부 체크 플래그
const thumbnailFlg = ref(true);

// 썸네일 미리보기용
const thumbnail = ref();

// 추가된 input v-model로 받아서 화면 출력
const stuffs = reactive([
  { stuff: '', stuff_gram: '' }
]);

const programs = reactive([
    { program: '', program_img: null, previewUrl: '' }
]);

// 추가 및 제거 함수
function addStuff(){
    stuffs.push({ stuff: '', stuff_gram: '' });
};

function removeStuff(index){
    stuffs.splice(index, 1);
};

function addPrograms(){
    programs.push({ program: '', program_img: null, previewUrl: '' });
};

function removePrograms(index){
    programs.splice(index, 1);
};

// 썸네일 미리보기
function thumbnailImg(e) {
    const file = e.target.files[0];
    if (!file) return;

    const imageUrl = URL.createObjectURL(file);
    thumbnail.value = imageUrl;
    thumbnailFlg.value = false;
}

// 진행과정 이미지 미리보기
function programImg(img, index) {
    const file = img.target.files[0];
    // programs[index].program_img = file;

    // 취소 누를경우 빈배열 생기는걸 방지
    if (!file) return;

    // 선택한 파일의 URL 생성
    const imageUrl = URL.createObjectURL(file);

    // 이미지 URL을 해당 프로그램에 저장
    programs[index].program_img = file;
    programs[index].previewUrl = imageUrl;
}

</script>
<style scoped src="../../css/recipeinsert.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>