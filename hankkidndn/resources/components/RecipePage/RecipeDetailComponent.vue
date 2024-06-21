<template>
    <div class="container">
        <div class="header">
            <div class="header-img-wrapper">
                <img class="header-img" :src="$store.state.recipeData.thumbnail">
                <button class="header-like">좋아요 버튼<img src="../../../public/img/like.png" alt=""></button>
                <div class="header-view">{{ $store.state.recipeData.views }}</div>
            </div>
            <div class="header-userinfo">
                <img class="header-profile" :src="$store.state.recipeData.profile">
                <div class="header-name">{{ $store.state.recipeData.u_nickname }}</div>
            </div>
        </div>

        <!-- 요리 제목과 간단설명 -->
        <div class="explain">
            <div class="explain-title">{{ $store.state.recipeData.title }}</div>
            <div>{{ $store.state.recipeData.content }}</div>
        </div>

        <!-- 재료 시작 -->
        <div class="stuff">
            <div class="stuff-title">재료</div>
            <div class="stuff-all" v-for="(item, index) in $store.state.recipeStuff" :key="index">
                <div class="stuff-name">{{ item.stuff }}</div>
                <div class="stuff-gram">{{ item.stuff_gram }}</div>
            </div>
        </div>
        <div class="line"></div>
        
        <!-- 레시피 과정 시작 -->
        <div class="recipe" v-for="(item, index) in $store.state.recipeProgram" :key="index" >
            <img class="recipe-img" :src="item.img_path">
            <div class="recipe-order">과정순서1</div>
            <div class="recipe-content">{{ item.program_content }}</div>
        </div>

        <!-- 동영상 링크 한개 -->
        <div class="video">
            <div class="video-title">{{ $store.state.recipeData.video_link }}</div>
        </div>

        <!-- 작성자 정보 -->
        <div class="profile">
            <div class="profile-title">레시피 작성자</div> <!-- 이건 고정제목 -->
            <img :src="$store.state.recipeData.profile" class="profile-img">
            <div class="profile-name">{{ $store.state.recipeData.u_nickname }}</div>
            <div class="profile-link">작성자 링크?</div>
        </div>

        <!-- 댓글 시작 -->
        <div class="comments">
            <div class="comments-title">요리후기 : 댓글수</div>
            <div class="line"></div>
            <div class="comment-container">
                <div class="comments-detail">
                    <img class="comment-img" src="" alt="">
                    <span class="comment-name">홍길동</span>
                    <span class="comment-date">2024-06-11 02:33</span>
                    <div class="comment-content">댓글내용</div>
                    <div class="comment-retouch">
                        <button>수정</button>
                        <button>삭제</button>
                    </div>
                    <div class="comment-reply">
                        <button class="comment-reply-btn">답글</button>
                    </div>
                </div>
            </div>
            <div class="comment-input">
                <textarea class="comment-input-content" name="" id=""></textarea>
                <button class="comment-input-btn">입력</button>
            </div>
        </div>
    </div>
</template>
<script setup>
import { onBeforeMount } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const store = useStore();
const route = useRoute();

onBeforeMount(() => {
    store.dispatch('getRecipeDetail', route.params.id);
})
</script>
<style scoped src="../../css/recipedetail.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>