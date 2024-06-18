<template>
    <div class="container">
        <div class="header">
            <div class="main-img">
                <img class="img-main" src="../../../public/img/recipe.png">
            </div>
            <div class="input-btn">
                <div>
                    <input class="search-input" type="text" required="Search..">
                </div>
                <div>
                    <button class="search" type="submit">
                        <img src="../../../public/img/search.png">
                    </button>
                </div>
            </div>
            <div class="ul-list">
                <ul>
                    <li @click="recipeTypeMove(100)" class="line">전체</li>
                    <li @click="recipeTypeMove(1)" class="line">한식</li>
                    <li @click="recipeTypeMove(2)" class="line">중식</li>
                    <li @click="recipeTypeMove(3)" class="line">일식</li>
                    <li @click="recipeTypeMove(4)" class="line">양식</li>
                    <li @click="recipeTypeMove(5)">베이커리</li>
                </ul>
            </div>
        </div>
        <div class="main-list">
            <div class="main-list-title">
                <h3>총 {{ $store.state.pagination.total }}개의 레시피가 있습니다.</h3>
                <button @click="$router.push('/recipe/insert')">레시피 작성하기</button>
                <button>최신순</button>
            </div>
            <div class="main-list-content">
                <div class="card" v-for="(item, index) in $store.state.recipeListData" :key="index">
                    <img :src="item.thumbnail" @click="$store.dispatch('moveDetail', item.id)">
                    <div class="card-title">{{ item.title }}</div>
                    <div class="card-name">{{ item.u_nickname }}</div>
                    <div class="star-view">
                        <div class="card-star">{{ item.created_at }}</div>
                        <div class="card-view">조회수 1.7만</div>
                    </div>
                </div>
            </div>
            <button @click="pageMove($store.state.pagination.current_page - 1)">이전</button>
            <div v-for="page_num in page" :key="page_num">
                <button @click="pageMove(page_num)">{{ page_num }}</button>
            </div>
            <button @click="pageMove($store.state.pagination.current_page + 1)">다음</button>
        </div>
    </div>
</template>

<script setup>

import { onBeforeMount, ref } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const store = useStore();
const route = useRoute();
const page = ref([]);
const now_page = route.query.page;
const last_page = store.state.pagination.last_page;
const start_page = (Math.ceil(now_page / 5)) * 5 - 4;
const max_page = Math.min(start_page + 4, last_page)
const data = {
    board_type: '',
    page: '',
};


function pagination() {
    for (let i = start_page; i <= max_page; i++) {
        page.value.push(i);
        console.log(page.value);
    }
}


// 최초~추가 게시글 획득
onBeforeMount(() => {

    pagination();

    // console.log(store.state.pagination);
    data.board_type = route.params.id;
    data.page = now_page;
    store.dispatch('getRecipeList', data);
});

// page 이동 버튼
function pageMove(page) {
    if(page >= 1 && page <= store.state.pagination.last_page) {
         data.page = page;
    
    store.dispatch('getRecipeList', data)
    }
}

// 레시피 타입 이동
function recipeTypeMove(type) {
    data.board_type = type
    data.page = 1
    store.dispatch('getRecipeList', data)
}


</script>

<style scoped src="../../css/recipelist.css">
    
</style>