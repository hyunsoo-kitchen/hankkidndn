<template>
    <div class="container">
        <div class="header">
            <div class="main-img">
                <img class="img-main" src="../../../public/img/main.png" >
            </div>
            <div class="ul-list">
                <ul>
                    <li :class="{ 'active': $route.params.id == 100 }" @click="recipeTypeMove(100)" class="line">진행중인 이벤트</li>
                    <li :class="{ 'active': $route.params.id == 1 }" @click="recipeTypeMove(1)" class="line">종료된 이벤트</li>
                </ul>
            </div>
        </div>
        <div class="main-list">
            <div class="main-list-content">
                <div @click="$store.dispatch('getRecipeDetail', item.id)" class="card" v-for="(item, index) in $store.state.eventListData" :key="index">
                    <img :src="item.thumbnail">
                    <div class="card-title">이벤트제목</div>
                    <div class="card-name">내용</div>
                    <div class="star-view">
                        <div class="card-star">{{ formatDate(item.created_at) }}</div>
                        <div class="card-view">조회수</div>
                    </div>
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

// 최초~추가 게시글 획득
onBeforeMount(() => {
    // console.log(store.state.pagination)
    data.board_type = route.params.id;
    data.page = route.query.page;
    store.dispatch('getEventList', data);
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
        store.dispatch('getEventList', data)
        pagination(route.query.page)
    }
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