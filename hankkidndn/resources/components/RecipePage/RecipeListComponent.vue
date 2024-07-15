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
                <img class="img-main" :src="currentImage" alt="Recipe Image">
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
            <div v-if="$route.path != '/recipe/99'" class="ul-list">
                <ul>
                    <li :class="{ 'active': $route.params.id == 100 }" @click="recipeTypeMove(100)" class="line">전체</li>
                    <li :class="{ 'active': $route.params.id == 1 }" @click="recipeTypeMove(1)" class="line">한식</li>
                    <li :class="{ 'active': $route.params.id == 2 }" @click="recipeTypeMove(2)" class="line">중식</li>
                    <li :class="{ 'active': $route.params.id == 3 }" @click="recipeTypeMove(3)" class="line">양식</li>
                    <li :class="{ 'active': $route.params.id == 4 }" @click="recipeTypeMove(4)" class="line">일식</li>
                    <li :class="{ 'active': $route.params.id == 5 }" @click="recipeTypeMove(5)">베이커리</li>
                </ul>
            </div>
        </div>
        <div class="main-list">
            <div class="main-list-title">
                <h3>총 {{ $store.state.pagination.total }}개의 레시피가 있습니다.</h3>
                <button v-if="$store.state.authFlg" @click="$router.push('/recipe/insert')">레시피 작성하기</button>
                <button v-if="!$store.state.authFlg" @click="insertModalOn()">레시피 작성하기</button>
                <!-- <button>최신순</button>
                <button>좋아요순</button>
                <button>조회순</button> -->
            </div>
            <div class="main-list-content">
                <div @click="$store.dispatch('getRecipeDetail', item.id)" class="card" v-for="(item, index) in $store.state.recipeListData" :key="index">
                <!-- <div @click="$router.push('/recipe/detail/' + item.id)" class="card" v-for="(item, index) in $store.state.recipeListData" :key="index"> -->
                    <div v-if="item.blind_flg !== 1">
                        <img :src="item.thumbnail">
                        <div class="card-title">{{ substringTitle(item.title, 15) }}</div>
                        <div class="card-name">{{ item.u_nickname }}</div>
                        <div class="star-view">
                            <div class="card-star">{{ formatDate(item.created_at) }}</div>
                            <div class="card-view">조회수 : {{ item.views }}</div>
                        </div>
                    </div>
                    <div v-else >해당 게시글은 신고로인해 <br> 블라인드 처리된 게시글입니다.</div>
                </div>
            </div>
            <div class="btn-container">
                <button v-if="$store.state.pagination.current_page !== 1" class="number" @click="pageMove($store.state.pagination.current_page - 1)">이전</button>
                <div v-for="page_num in page" :key="page_num">
                    <button :class="{ activePage: page_num === $store.state.pagination.current_page }" class="number" @click="pageMove(page_num)">{{ page_num }}</button>
                </div>
                <button v-if="$store.state.pagination.current_page < $store.state.pagination.last_page" class="number" @click="pageMove($store.state.pagination.current_page + 1)">다음</button>
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

const data = {
    board_type: '',
    page: '',
    search: '',
};
 

watch(() => [route.query.page, route.params.id], ([newPage, newId]) => {
    data.page = newPage;
    data.board_type = newId
    currentImage.value = imageMap[newId] || imageMap[100];
    pagination(newPage);
    store.dispatch('getRecipeList', data);
});


function pagination(nowPage) {
    const last_page = store.state.pagination.last_page;
    const start_page = (Math.ceil(nowPage / 5)) * 5 - 4;
    const max_page = Math.min(start_page + 4, last_page)
    page.value = [];
    for (let i = start_page; i <= max_page; i++) {
        page.value.push(i);
    }
}

const imageMap = {
  100: '/img/recipe.png',
  99: '/img/best.png',
  1: '/img/koreanfood.jpg',
  2: '/img/chinesefood.jpg',
  3: '/img/pastafood.jpg',
  4: '/img/japanfood.jpg',
  5: '/img/breadfood.jpg'
};

const currentImage = ref(imageMap[100]);

// 최초~추가 게시글 획득
onBeforeMount(() => {
    // console.log(store.state.pagination)
    data.board_type = route.params.id;
    data.page = route.query.page;
    currentImage.value = imageMap[data.board_type];
    store.dispatch('getRecipeList', data);
    const interval = setInterval(() => {
        pagination(route.query.page);
        if(store.state.pagination.last_page) {
            clearInterval(interval);
        }
    }, 500);
});

// page 이동 버튼
function pageMove(page) {
    if(page >= 1 && page <= store.state.pagination.last_page) {
        data.page = page;
        store.dispatch('getRecipeList', data)
        pagination(route.query.page)
    }
}

// 레시피 타입 이동
function recipeTypeMove(type) {
    data.board_type = type
    data.page = 1
    store.dispatch('getRecipeList', data)
}

// 검색 추가 
function search() {
    data.board_type = '100';
    data.page = '1';
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

// 글자 많을 때 자르기용
function substringTitle(text, max){
    if (text.length > max) {
        return text.substring(0, max) + '...';
    }
    return text;
}
</script>

<style scoped src="../../css/recipelist.css">
    
</style>