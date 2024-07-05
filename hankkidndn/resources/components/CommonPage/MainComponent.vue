<template>
    <CategoryComponent/>
    <div class="header">
        <Swiper
        :spaceBetween="30"
        :centeredSlides="true"
        :autoplay="{
        delay: 2500,
        disableOnInteraction: false,
        }"
        :pagination="{
        clickable: true,
        }"
        :navigation="true"
        :modules="modules"
        class="header-img-container">
            <swiper-slide><img class="header-img" src="../../../public/img/main.png"></swiper-slide>
            <swiper-slide><img class="header-img" src="../../../public/img/main55.png"></swiper-slide>
            <swiper-slide><img class="header-img" src="../../../public/img/main5.png"></swiper-slide>
            <swiper-slide><img class="header-img" src="../../../public/img/main444.png"></swiper-slide>
            <swiper-slide><img class="header-img" src="../../../public/img/main4.jpg"></swiper-slide>
        </Swiper>
    </div>
    <h1 class="text-center text-gray">한끼든든에 오신 분들 환영합니다</h1>
    <div class="body-container">
        <div class="category">
            <!-- 카테고리 돌릴거 -->
            <div @click="$router.push('/recipe/1?page=1')" class="point">
                <img class="category-img" src="/img/koreanfood.jpg" alt="">
                <p class="text-gray text-thick">한식</p>
                <br>
                <p class="text-gray">모든 한식 레시피</p>
            </div>
            <div @click="$router.push('/recipe/2?page=1')" class="point">
                <img class="category-img" src="/img/chinesefood.jpg" alt="">
                <p class="text-gray text-thick">중식</p>
                <br>
                <p class="text-gray">모든 중식 레시피</p>
            </div>
            <div @click="$router.push('/recipe/3?page=1')" class="point">
                <img class="category-img" src="/img/pastafood.jpg" alt="">
                <p class="text-gray text-thick">양식</p>
                <br>
                <p class="text-gray">모든 양식 레시피</p>
            </div>
            <div @click="$router.push('/recipe/4?page=1')" class="point">
                <img class="category-img" src="/img/japanfood.jpg" alt="">
                <p class="text-gray text-thick">일식</p>
                <br>
                <p class="text-gray">모든 일식 레시피</p>
            </div>
            <div @click="$router.push('/recipe/5?page=1')" class="point">
                <img class="category-img" src="/img/breadfood.jpg" alt="">
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
                    <p class="text-white">{{ formatDate(item.created_at) }}</p>
                </div>
                <div class="new-recipe-body">
                    <p class="new-recipe-title text-white">{{ item.title }}</p>
                    <div class=""></div>
                    <p class="text-left text-white"> 조회수 : {{ item.views }}</p>
                    <!-- <p class="text-left text-white">{{ item.cnt }}</p> -->
                    <!-- <p class="text-right text-white">{{ item.like_chk }}</p> -->
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
                    <img class="best-recipe-profile" :src="item.profile">
                    <div class="best-recipe-title">
                        <p class="text-gray">{{ item.u_nickname }}</p>
                        <p class="text-gray">{{ formatDate(item.created_at) }}</p>
                    </div>
                </div>
                <div class="best-recipe-content" >
                    <p class="text-thick font-big">{{ substringTitle(item.title, 20) }}</p>
                    <p class="text-gray">{{ substringTitle(item.content, 20) }}</p>
                    </div>
                <div class="info-line"></div>
                <!-- <div class="best-recipe-footer"> -->
                <div>
                    <p>조회수 : {{ item.views }}</p>
                    <!-- <p>{{ item.cnt }}</p> -->
                    <!-- <p>{{ item.like_chk }}</p> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onBeforeMount } from 'vue';
import { useStore } from 'vuex';
import CategoryComponent from './CategoryComponent.vue';

   // 스와이퍼
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';

const modules = [Autoplay, Pagination, Navigation];
const store = useStore();

onBeforeMount(() => {
    store.dispatch('getMainNewList');
});

// 날짜 표시 제어
const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('ko-KR', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    }).replace(/\.$/, '');  // 마지막 점제거
};

// 글자 많을 때 자르기용
function substringTitle(text, max){
    if (text.length > max) {
        return text.substring(0, max) + '...';
    }
    return text;
}

</script>

<style scoped src="../../css/main.css">
    
</style>