<template>
    <div class="container">
        <div class="header">
            <img class="main-img" src="../../../public/img/recipe_order.png">
        </div>
        <div class="main-list">
            <div class="head-title">
                <h3>공지 게시판</h3>
            </div>
            <div class="text-box-head">
                <div class="list-number">번호</div>
                <div class="list-title">제목</div>
                <div class="list-ninkname">내용</div>
                <div class="list-day">등록일</div>
            </div>
            <!-- 리스트 클릭시 해당 디테일 게시글로 이동 -->
            <div @click="$store.dispatch('getNoticeDetail', item.id)" class="text-box" v-for="(item, index) in $store.state.noticeListData" :key="index">
                <!-- 게시글 출력 -->
                <div class="list-number">{{ ($store.state.noticePagination.total - index) - (($store.state.noticePagination.current_page - 1) * 10) }}</div>
                <div class="list-title">{{ substringTitle(item.title, 10) }}</div>
                <div class="list-ninkname">{{ substringTitle(item.content, 10) }}</div>
                <div class="list-day">{{ formatDate(item.created_at) }}</div>
            </div>
            <div class="btn-container">
                <!-- 페이지 네이션 처리 -->
                <button v-if="$store.state.noticePagination.current_page !== 1" class="number" @click="pageMove($store.state.noticePagination.current_page - 1)">이전</button>
                <div v-for="page_num in pages" :key="page_num">
                    <button :class="{ activePage: page_num === $store.state.noticePagination.current_page }" class="number" @click="pageMove(page_num)">{{ page_num }}</button>
                </div>
                <button v-if="$store.state.noticePagination.current_page < $store.state.noticePagination.last_page" class="number" @click="pageMove($store.state.noticePagination.current_page + 1)">다음</button>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, onBeforeMount, watch } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

    
const store = useStore();
const route = useRoute();
const pages = ref([]);
const page = ref();

// watch로 route.query.page(router.js의 현재페이지) 가 바뀔때마다 안에 함수들을 실행
watch(() => route.query.page, (newPage) => {
    page.value = newPage;
    pagination(newPage);
    store.dispatch('getBoardNoticeList', page.value);
});

function pagination(nowPage) {
    const last_page = store.state.noticePagination.last_page;
    const start_page = (Math.ceil(nowPage / 5)) * 5 - 4;
    const max_page = Math.min(start_page + 4, last_page)
    pages.value = [];
    for (let i = start_page; i <= max_page; i++) {
        pages.value.push(i);
    }
}

// page 이동 버튼
function pageMove(nowPage) {
    if(nowPage >= 1 && nowPage <= store.state.noticePagination.last_page) {
        page.value = nowPage;
        store.dispatch('getBoardNoticeList', nowPage)
        pagination(route.query.page)
    }
}

onBeforeMount(() => {
    page.value = route.query.page;
    store.dispatch('getBoardNoticeList', page.value);
    const interval = setInterval(() => {
        pagination(route.query.page);
        if(store.state.noticePagination.last_page) {
            clearInterval(interval);
        }
    }, 500);
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

<style scoped src="../../css/boardlist.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>