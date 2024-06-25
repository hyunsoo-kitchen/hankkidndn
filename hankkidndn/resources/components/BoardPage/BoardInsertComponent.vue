<template>
<form id="boardInsertForm">
    <div class="container">
        <div class="header">
            <img class="main_img" src="../../../public/img/recipe_order.png">
        </div>
        <div class="main_list">
            <h2>글 작성</h2>
            <hr>
            <div class="select_why">
                <select name="boards_type_id">
                    <option value="7">자유게시판</option>
                    <option value="8">질문게시판</option>
                    <option value="9">문의게시판</option>
                </select>
                <label for="file">
                    <div>이미지 파일</div>
                </label>
                <input hidden @change="setFile" type="file" id="file" name="file[]" accept="image/*" multiple>
            </div>
            <input autocomplete="off" name="title" type="text" placeholder="제목">
            <div class="content-box">
                <img v-for="(item, index) in preview" :key="index" :src="item">
                <textarea autocomplete="off" name="content" rows="30" placeholder="내용을 입력해주세요"></textarea>
            </div>
            <div class="buttons">
                <button type="button" @click="$store.dispatch('boardInsert')" class="complete">작성하기</button>
                <button type="button" @click="$router.back()" class="cancel ">취소</button>
            </div>
        </div>
    </div>
</form>
</template>
<script setup>
import { ref } from 'vue';
const preview = ref([]);

function setFile(e) {
    const file = e.target.files;
    const fileList = [];
    if(file.length > 5) {
        alert('이미지 파일은 최대 5개까지 선택할 수 있습니다.')
        e = null;
        return
    }
    for(let i = 0; i < file.length; i++) {
        fileList.push(URL.createObjectURL(file[i]));
    }
    preview.value = fileList;
};

</script>
<style scoped src="../../css/boardinsert.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>