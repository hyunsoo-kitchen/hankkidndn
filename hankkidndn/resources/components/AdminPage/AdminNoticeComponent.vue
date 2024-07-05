<template>
    <div class="head_container">
        <div class="head_logo">
            <img class="img-logo" alt="logo" src="../../../public/img/logo.png">
        </div>
        <div class="head_title">한끼든든</div>
        <div></div>
        <div>
            <p>admin0001</p>    
        </div>
        <div>
            <button @click="$store.dispatch('adminLogout')" type="button" >로그아웃</button>
        </div>
    </div>

    <div class="body_container">
        <div class="category">
            <button class="category_btn">대시보드</button>
            <button class="category_btn">공지사항</button>
            <button class="category_btn">사용자 관리</button>
            <button class="category_btn">컨텐츠 관리</button>
            <button class="category_btn">광고, 캠페인 관리</button>
            <button class="category_btn">통계</button>
        </div>

        <div class="notice-container">
            <div class="notice-header">
                <h3>공지사항</h3>
                <button type="button" @click="openNotice()">글 쓰기</button>
            </div>
            <div class="notice-body">
                <div>공지 번호</div>
                <div>공지 제목</div>
                <div>공지 작성일</div>
                <div>댓글 수</div>
            </div>
        </div>

        <div v-if="noticeFlg" class="notice-write">
            <form id="noticeForm">
                <input autocomplete="off" name="title" type="text" placeholder="제목. (최대 100자까지 작성 가능합니다.)">
                <div class="content-box">
                    <textarea autocomplete="off" name="content" rows="30" placeholder="내용을 입력해주세요. (최대 1000자까지 작성 가능합니다.)"></textarea>
                </div>
                <div class="buttons">
                    <button type="button" @click="$store.dispatch('noticeInsert'); closeNotice()" class="complete">작성하기</button>
                    <button type="button" @click="closeNotice()" class="cancel ">취소</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';

const noticeFlg = ref(false);

function openNotice() {
    noticeFlg.value = true;
}

function closeNotice() {
    noticeFlg.value = false;
}

</script>
<style scoped src="../../css/admin_content.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>