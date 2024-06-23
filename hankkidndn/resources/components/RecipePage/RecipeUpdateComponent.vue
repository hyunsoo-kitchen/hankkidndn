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
                    <input name="thumbnail" type="file" accept="image/*" >
                    <input class="column_2to3" type="text" name="title" id="title" placeholder="예) 소고기 무국">
                </div>
                <div class="section grid_box">
                    <label class="column_1to2 title_font" for="summary"><h3>요리소개</h3></label>
                    <textarea class="column_2to3to" id="content" name="content" placeholder="예) " rows="5"></textarea>
                </div>
                <div class="section grid_box">
                    <label class="column_1to2 title_font" for="video"><h3>동영상</h3></label>
                    <input class="column_2to3" type="url" id="video" name="video" placeholder="예) 영상이 youtube에 있다면 주소를 넣어주세요. https://youtu.be/abcd1234"></input>
                </div>
            </div>

            <!-- 재료 추가 -->
            <div class="section">
                <h3>재료 정보</h3>
                <div id="ingredients">
                    <div class="ingredient_row ingredient_box" v-for="(item, index) in stuffs" :key="index">
                        <input class="note_input1 ingredient_content" type="text" v-model="item.stuff" name="stuff[]" placeholder="재료 예)돼지고기">
                        <input class="note_input ingredient_content" type="text" name="stuff_gram[]" v-model="item.stuff_gram" placeholder="예)g, ml(단위)">
                        <!-- <input class="note_input ingredient_content" type="text" name="quantity[]" placeholder="10(수량)"> -->
                        <!-- <input class="note_input ingredient_content" type="text" name="" placeholder="예) (비고)"> -->
                        <button v-if="stuffs.length > 2" @click="removeStuff(item)" class="remove_btn ingredient_content delete_btn" type="button">제거</button>
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
                <div class="content_list" v-for="(item, index) in programs" :key="index">
                    <p> Step {{ index + 1 }}</p>
                    <textarea class="text-list" name="list[]" id="list" v-model="item.program" placeholder="예 ) 소고기를 기름에 두른 팬에" rows="5"></textarea>
                    <input name="file[]" type="file" accept="image/*" @change="programImg($event, index)" >
                    <button v-if="programs.length > 2" @click="removePrograms(item)" class="list-btn-start" type="button">순서 제거</button>
                </div>
            </div>

            <!-- 요리 팁 -->
            <div class="cooktip">
                <h3>요리팁</h3>
                <textarea name="tip" id="tip" placeholder="예) 고기가 타지않도록 . . ." rows="3"></textarea>
            </div>
            <div class="actions">
                <button @click="$store.dispatch('recipeInsert')" type="button">저장</button>
                <!-- <button type="button" id="saveAndShare">저장 후 공개하기</button> -->
                <button type="button" id="cancel">취소</button>
            </div>
        </form>
    </div>
</template>
<script setup>
import { reactive } from 'vue';

// 추가된 input v-model로 받아서 화면 출력
const stuffs = reactive([
  { stuff: '', stuff_gram: '' },
  { stuff: '', stuff_gram: '' }
]);

const programs = reactive([
  { program: '', program_img: null }
]);

// 추가 및 제거 함수
function addStuff(){
    stuffs.push({ stuff: '', stuff_gram: '' });
};

function removeStuff(index){
    stuffs.splice(index, 1);
};

function addPrograms(){
    programs.push({ program: '', program_img: null });
};

function removePrograms(index){
    programs.splice(index, 1);
};

function programImg(img, index) {
    const file = img.target.files[0];
    programs[index].program_img = file;
}

</script>
<style scoped src="../../css/recipeinsert.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>