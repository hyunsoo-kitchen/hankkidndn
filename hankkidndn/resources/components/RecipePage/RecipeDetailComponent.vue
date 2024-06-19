<template>
    <div class="container">
        <div class="header">
            <div class="header-img-wrapper">
                <img class="header-img" src="" alt="">
                <button class="header-like"><img src="../../../public/img/like.png" alt=""></button>
                <div class="header-view">뷰123</div>
            </div>
            <div class="header-userinfo">
                <img class="header-profile" src="" alt="">
                <div class="header-name">{{ $store.state.recipeDetail.nickname }}</div>
            </div>
        </div>
        <div class="explain">
            <div class="explain-title">{{ $store.state.recipeDetail.title }}</div>
            <div>{{ $store.state.recipeDetail.content }}</div>
        </div>
        <div class="stuff">
            <div class="stuff-title">재료</div>
            <div class="stuff-all">
                <div class="stuff-name">{{ $store.state.recipeDetail.stuff }} : </div>
                <div class="stuff-gram">{{ $store.state.recipeDetail.stuff_gram }} : </div>
            </div>
        </div>
        <div class="line"></div>
        <div class="recipe">
            <img class="recipe-img" :src="$store.state.recipeDetail.img_path" alt="">
            <div class="recipe-order">순서1</div>
            <div class="recipe-content">{{ $store.state.recipeDetail.program_content }}</div>
        </div>
        <div class="video">
            <div class="video-title">동영상</div>
            <img class="video-play" src="" alt="">
            <!-- <div class="video-play">영상</div> -->
        </div>
        <div class="profile">
            <div class="profile-title">레시피 작성자</div>
            <img src="" alt="" class="profile-img">
            <div class="profile-name">{{ $store.state.recipeDetail.profile }}</div>
            <div class="profile-link">{{ $store.state.recipeDetail.video_link }}</div>
        </div>
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
import { useStore } from 'vuex';
</script>
<style scoped src="../../css/recipedetail.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>