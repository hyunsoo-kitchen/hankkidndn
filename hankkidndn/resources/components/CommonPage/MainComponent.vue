<template>
    <CategoryComponent/>
    <div class="header">
        <img class="header-img" src="" alt="">
    </div>
    <h1 class="text-center text-gray">한끼든든에 오신 분들 환영합니다</h1>
    <div class="body-container">
        <div class="category">
            <div>
                <img class="category-img" src="" alt="">
                <p class="text-gray text-thick">한식</p>
                <br>
                <p class="text-gray">모든 한식 레시피</p>
            </div>
        </div>
        <div class="line media-display"></div>
        <img class="logo" src="" alt="">
        <h2 class="text-center text-gray">최신 레시피</h2>
        <div class="new-recipe">
            <div class="new-recipe-card">
                <img class="new-recipe-img" src="" alt="">
                <div class="new-recipe-header">
                    <p class="text-white">사용자</p>
                    <p class="text-white">날짜</p>
                </div>
                <div class="new-recipe-body">
                    <p class="new-recipe-title text-white">어쩌고저쩌고 제목</p>
                    <div class=""></div>
                    <p class="text-left text-white">조회수</p>
                    <p class="text-left text-white">뷰 댓글</p>
                    <p class="text-right text-white">좋아요</p>
                </div>
            </div>
        </div>
        <div class="line"></div>
        <img class="logo" src="" alt="">
        <h2 class="text-center text-gray">베스트 레시피</h2>
        <div class="best-recipe">
            <div class="best-recipe-card">
                <img class="best-recipe-img" src="" alt="">
                <div class="best-recipe-info" >
                    <img class="best-recipe-profile" src="" alt="">
                    <div class="best-recipe-title">
                        <p class="text-gray">사용자</p>
                        <p class="text-gray">날짜</p>
                    </div>
                </div>
                <div class="best-recipe-content" >
                    <p class="text-thick font-big">어쩌고저쩌고 제목</p>
                    <p class="text-gray">설명</p>
                    <div class="line"></div>
                </div>
                <div class="best-recipe-footer">
                    <p>댓글</p>
                    <p>조회수</p>
                    <p>좋아요</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import CategoryComponent from './CategoryComponent.vue';

</script>

<style scoped src="../../css/main.css">
    
</style>