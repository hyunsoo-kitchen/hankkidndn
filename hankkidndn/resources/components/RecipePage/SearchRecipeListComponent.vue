<template>
    <div class="modal" v-show="insertModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">알림</h3>
            <button @click="insertModalOff" class="close">×</button>
          </div>
          <div class="modal-body">
            <p>글 작성은 로그인 후 가능합니다.</p>
          </div>
          <div class="modal-footer">
            <button @click="insertModalOff(); $router.push('/login')" class="btn btn-primary">확인</button>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
        <div class="header">
            <div class="main-img">
                <img class="img-main" src="/img/recipe.png">
            </div>
            <div class="input-btn">
                <div>
                    <input v-model="data.search" class="search-input" type="text" placeholder   ="Search..">
                </div>
                <div>
                    <button  @click="search" class="search" type="button">
                        <img src="/img/search.png">
                    </button>
                </div>
            </div>
            <div class="ul-list">
                <ul>
                    <li :class="{ 'active': activeType === 100 }" @click="recipeTypeMove(100)" class="line">전체</li>
                    <li :class="{ 'active': activeType === 1 }" @click="recipeTypeMove(1)" class="line">한식</li>
                    <li :class="{ 'active': activeType === 2 }" @click="recipeTypeMove(2)" class="line">중식</li>
                    <li :class="{ 'active': activeType === 3 }" @click="recipeTypeMove(3)" class="line">일식</li>
                    <li :class="{ 'active': activeType === 4 }" @click="recipeTypeMove(4)" class="line">양식</li>
                    <li :class="{ 'active': activeType === 5 }" @click="recipeTypeMove(5)">베이커리</li>
                </ul>
            </div>
        </div>
        <div class="main-list">
            <div class="main-list-title">
                <h3>총 {{ $store.state.searchPagination.total }}개의 레시피가 있습니다.</h3>
                <button v-if="$store.state.authFlg" @click="$router.push('/recipe/insert')">레시피 작성하기</button>
                <button v-if="!$store.state.authFlg" @click="insertModalOn()">레시피 작성하기</button>
                <!-- <div>{{ $store.state.searchPagination.current_page }}</div> -->
            </div>
            <div class="main-list-content">
                <div @click="$store.dispatch('getRecipeDetail', item.id)" class="card" v-for="(item, index) in $store.state.searchRecipeListData" :key="index">
                    <img :src="item.thumbnail">
                    <div class="card-title">{{ item.title }}</div>
                    <div class="card-name">{{ item.u_nickname }}</div>
                    <div class="star-view">
                        <div class="card-star">{{ formatDate(item.created_at) }}</div>
                        <div class="card-view">조회수 : {{ item.views }}</div>
                    </div>
                </div>
            </div>
            <div class="btn-container">
                <button v-if="$store.state.searchPagination.current_page !== 1" class="number" @click="pageMove($store.state.searchPagination.current_page - 1)">이전</button>
                <div v-for="page_num in page" :key="page_num">
                    <button :class="{ activePage: page_num === $store.state.searchPagination.current_page }" class="number" @click="pageMove(page_num)">{{ page_num }}</button>
                </div>
                <button v-if="$store.state.searchPagination.current_page < $store.state.searchPagination.last_page" class="number" @click="pageMove($store.state.searchPagination.current_page + 1)">다음</button>
            </div>
        </div>
    </div>
</template>

<script setup>

import { onBeforeMount, ref, watch } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';


const store = useStore();
const route = useRoute();
const page = ref([]);
const insertModal = ref(false);

onBeforeMount(() => {
    pagination(route.query.page);
});

const data = {
    board_type: '',
    page: route.query.page,
    search: route.query.search,
};

const activeType = ref(100);    
const searchQuery = ref('');
const filteredRecipes = ref([]);
 

watch(() => [route.query.page, route.query.search], ([newPage, newSearch]) => {
    data.page = newPage;
    data.search = newSearch
    pagination(newPage);
    // store.dispatch('searchRecipes', data);
});

function pagination(nowPage) {
    const last_page = store.state.searchPagination.last_page;
    const start_page = (Math.ceil(nowPage / 5)) * 5 - 4;
    const max_page = Math.min(start_page + 4, last_page)
    page.value = [];
    for (let i = start_page; i <= max_page; i++) {
        page.value.push(i);
    }
}

// page 이동 버튼
function pageMove(page) {
    if(page >= 1 && page <= store.state.searchPagination.last_page) {
        data.page = page;
        store.dispatch('searchRecipes', data)
        pagination(route.query.page)
        }
}

// 레시피 타입 이동
function recipeTypeMove(type) {
    activeType.value = type;
    data.board_type = type
    data.page = 1
    store.dispatch('getRecipeList', data)
}


// 검색 추가 
function search() {
    data.board_type = '100';
    data.page = route.query.page;
    store.dispatch('searchRecipes', data);
}

// 비로그인시 작성 모달창
function insertModalOn() {
    insertModal.value = true;
}

function insertModalOff() {
    insertModal.value = false;
}

// 날짜 표시 제어
const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('ko-KR', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    }).replace(/\.$/, ''); 
};

</script>

<style scoped src="../../css/recipelist.css">
    
</style>