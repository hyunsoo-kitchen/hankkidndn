<template>
    <CategoryComponent/>
    <div class="header">
        <img class="header-img" src="../../../public/img/main.png" alt="">
    </div>
    <h1 class="text-center text-gray">한끼든든에 오신 분들 환영합니다</h1>
    <div class="body-container">
        <div class="category">
            <!-- 카테고리 돌릴거 -->
            <div @click="$router.push('/recipe/1?page=1')">
                <img class="category-img" src="../../../public/img/main.png" alt="">
                <p class="text-gray text-thick">한식</p>
                <br>
                <p class="text-gray">모든 한식 레시피</p>
            </div>
            <div @click="$router.push('/recipe/2?page=1')">
                <img class="category-img" src="../../../public/img/main.png" alt="">
                <p class="text-gray text-thick">중식</p>
                <br>
                <p class="text-gray">모든 중식 레시피</p>
            </div>
            <div @click="$router.push('/recipe/3?page=1')">
                <img class="category-img" src="../../../public/img/main.png" alt="">
                <p class="text-gray text-thick">양식</p>
                <br>
                <p class="text-gray">모든 양식 레시피</p>
            </div>
            <div @click="$router.push('/recipe/4?page=1')">
                <img class="category-img" src="../../../public/img/main.png" alt="">
                <p class="text-gray text-thick">일식</p>
                <br>
                <p class="text-gray">모든 일식 레시피</p>
            </div>
            <div @click="$router.push('/recipe/5?page=1')">
                <img class="category-img" src="../../../public/img/main.png" alt="">
                <p class="text-gray text-thick">베이커리</p>
                <br>
                <p class="text-gray">모든 베이커리 레시피</p>
            </div>
        </div>
        <div class="line media-display"></div>
        <img class="logo" src="../../../public/img/logo.png" alt="">
        <h2 class="text-center text-gray">최신 레시피</h2>
        <div class="new-recipe" >
            <!-- 새로운 레시피 돌릴거 -->
            <div @click="$store.dispatch('getRecipeDetail', item.id)" class="new-recipe-card" v-for="(item, key) in $store.state.mainNewData" :key="key">
                <img class="new-recipe-img" :src="item.thumbnail">
                <div class="new-recipe-header">
                    <p class="text-white">{{ item.u_nickname }}</p>
                    <p class="text-white">{{ item.created_at }}</p>
                </div>
                <div class="new-recipe-body">
                    <p class="new-recipe-title text-white">{{ item.title }}</p>
                    <div class=""></div>
                    <p class="text-left text-white">조회수</p>
                    <p class="text-left text-white">{{ item.cnt }}</p>
                    <p class="text-right text-white">{{ item.like_chk }}</p>
                </div>
            </div>
        </div>
        <div class="line"></div>
        <img class="logo" src="" alt="">
        <h2 class="text-center text-gray">베스트 레시피</h2>
        <div class="best-recipe">
            <!-- 베스트 레시피 돌릴거 -->
            <div @click="$store.dispatch('getRecipeDetail', item.id)" class="best-recipe-card" v-for="(item, key) in $store.state.mainBestData" :key="key">
                <img class="best-recipe-img" :src="item.thumbnail">
                <div class="best-recipe-info">
                    <img class="best-recipe-profile" :src="item.profile" alt="">
                    <div class="best-recipe-title">
                        <p class="text-gray">{{ item.u_nickname }}</p>
                        <p class="text-gray">{{ item.created_at }}</p>
                    </div>
                </div>
                <div class="best-recipe-content" >
                    <p class="text-thick font-big">{{ item.title }}</p>
                    <p class="text-gray">{{ item.content }}</p>
                    </div>
                <div class="line"></div>
                <div class="best-recipe-footer">
                    <p>{{ item.cnt }}</p>
                    <p>조회수</p>
                    <p>{{ item.like_chk }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onBeforeMount } from 'vue';
import { useStore } from 'vuex';
import CategoryComponent from './CategoryComponent.vue';

const store = useStore();

onBeforeMount(() => {
    store.dispatch('getMainNewList');
});

</script>

<style scoped src="../../css/main.css">
    
</style>