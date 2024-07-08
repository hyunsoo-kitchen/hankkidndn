<template>
    <div class="head_container">
        <div class="head_logo">
            <img class="img-logo" alt="logo" src="../../../public/img/logo.png">
        </div>
        <div class="head_title">한끼든든</div>
        <div></div>
        <div>
            <p>admin0001</p>    
        </div>
        <div>
            <button @click="$store.dispatch('adminLogout')" type="button" >로그아웃</button>
        </div>
    </div>

    <div class="body_container">
        <div class="category">
            <button class="category_btn">대시보드</button>
            <button class="category_btn">공지사항</button>
            <button class="category_btn">사용자 관리</button>
            <button class="category_btn">컨텐츠 관리</button>
            <button class="category_btn">광고, 캠페인 관리</button>
            <button class="category_btn">통계</button>
        </div>

        <div v-if="!noticeFlg" class="notice-container">
            <div class="notice-header">
                <h2>공지사항</h2>
                <button type="button" @click="openNotice()">글 쓰기</button>
            </div>
            <div class="notice-body">
                <div>공지 번호</div>
                <div>공지 제목</div>
                <div>공지 내용</div>
                <div>공지 작성일</div>
            </div>
            <div @click="$store.dispatch('getNoticeDetail', item.id)" class="notice-content" v-for="(item, index) in $store.state.noticeListData" :key="index">
                <div>{{ ($store.state.noticePagination.total - index) - (($store.state.noticePagination.current_page - 1) * 10) }}</div>
                <div>{{ substringTitle(item.title, 10) }}</div>
                <div>{{ substringTitle(item.content, 10) }}</div>
                <div>{{ formatDate(item.created_at) }}</div>
            </div>
            <div class="notice-pagination">
                <button v-if="$store.state.noticePagination.current_page !== 1" class="number" @click="pageMove($store.state.noticePagination.current_page - 1)">이전</button>
                <div v-for="page_num in pages" :key="page_num">
                    <button class="number" @click="pageMove(page_num)">{{ page_num }}</button>
                    <!-- <button :class="{ activePage: page_num === $store.state.noticePagination.current_page }" class="number" @click="pageMove(page_num)">{{ page_num }}</button> -->
                </div>
                <button v-if="$store.state.noticePagination.current_page < $store.state.noticePagination.last_page" class="number" @click="pageMove($store.state.noticePagination.current_page + 1)">다음</button>
            </div>
        </div>

        <div v-if="noticeFlg" class="notice-write">
            <form id="noticeForm">
                <h2>공지사항 작성</h2>
                <input autocomplete="off" name="title" type="text" placeholder="제목. (최대 100자까지 작성 가능합니다.)">
                <div class="content-box">
                    <textarea autocomplete="off" name="content" rows="30" placeholder="내용을 입력해주세요. (최대 1000자까지 작성 가능합니다.)"></textarea>
                </div>
                <div class="buttons">
                    <button type="button" @click="$store.dispatch('noticeInsert'); closeNotice()" class="complete">작성하기</button>
                    <button type="button" @click="closeNotice()" class="cancel ">취소</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script setup>
import { ref, onBeforeMount, watch } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

    
const store = useStore();
const route = useRoute();
const noticeFlg = ref(false);
const pages = ref([]);
const page = ref();

function openNotice() {
    noticeFlg.value = true;
}

function closeNotice() {
    noticeFlg.value = false;
}

// watch로 route.query.page(router.js의 현재페이지) 가 바뀔때마다 안에 함수들을 실행
watch(() => route.query.page, (newPage) => {
    page.value = newPage;
    pagination(newPage);
    store.dispatch('getNoticeList', page.value);
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
        store.dispatch('getNoticeList', nowPage)
        pagination(route.query.page)
    }
}

onBeforeMount(() => {
    page.value = route.query.page;
    store.dispatch('getNoticeList', page.value);
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
<style scoped src="../../css/admin_notice.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>