<template>
    <div class="container">
        <div class="header">
            <img class="main-img" src="../../../public/img/recipe_order.png">
            <div class="ul-list">
                <ul>
                    <li :class="{ 'active': activeType === 6}" @click="boardTypeMove(6)" class="line">공지게시판</li>
                    <li :class="{ 'active': activeType === 7}" @click="boardTypeMove(7)" class="line">자유게시판</li>
                    <li :class="{ 'active': activeType === 8}" @click="boardTypeMove(8)" class="line">질문게시판</li>
                    <li :class="{ 'active': activeType === 9}" @click="boardTypeMove(9)" class="line">문의게시판</li>
                </ul>
            </div>
        </div>
        <div class="main-list">
            <div class="head-title">
                <h3>{{ getBoardName($route.params.id) }}</h3>
                <form action="#">
                    <div class="search-bar">
                        <select name="name-tag" id="name-tag">
                            <option value="title">제목</option>
                            <option value="nickname">닉네임</option>
                        </select>
                        <input type="text">
                        <button type="submit"><img src="../../../public/img/search.png"></button>
                    </div>
                </form>
            </div>
            <div class="text-box-head">
                <div class="list-number">번호</div>
                <div class="list-title">제목</div>
                <div class="list-ninkname">닉네임</div>
                <div class="list-day">등록일</div>
            </div>
            <!-- 리스트 클릭시 해당 디테일 게시글로 이동 -->
            <div @click="$store.dispatch('getBoardDetail', item.id)" class="text-box" v-for="(item, index) in $store.state.boardListData" :key="index">
                <!-- 게시글 출력 -->
                <div class="list-number">{{ ($store.state.pagination.total - index) - (($store.state.pagination.current_page - 1) * 10) }}</div>
                <div class="list-title">{{ item.title }}</div>
                <div class="list-ninkname">{{ item.u_nickname }}</div>
                <div class="list-day">{{ item.created_at }}</div>
            </div>
            <div class="btn-box">
                <!-- 클릭시 글쓰기 페이지로 이동 -->
                <button @click="$router.push('/board/insert')" class="text-btn" type="button">글쓰기</button>
            </div>
            <div class="btn-container">
                <!-- 페이지 네이션 처리 -->
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
let page = ref([]);
const data = {
    board_type: '',
    page: '',
};
const activeType = ref(6);

// watch로 route.query.page(router.js의 현재페이지) 가 바뀔때마다 안에 함수들을 실행
watch(() => [route.query.page, route.params.id], ([newPage, newId]) => {
    data.page = newPage;
    data.board_type = newId
    pagination(newPage);
    store.dispatch('getBoardList', data);
});

// 페이지네이션
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
    pagination(route.query.page);
    data.board_type = route.params.id;
    data.page = route.query.page;
    store.dispatch('getBoardList', data);
});

// page 이동 버튼
function pageMove(page) {
    if(page >= 1 && page <= store.state.pagination.last_page) {
        data.page = page;
        store.dispatch('getBoardList', data)
        pagination(route.query.page)
    }
}

// 레시피 타입 이동
function boardTypeMove(type) {
    activeType.value = type;
    data.board_type = type
    data.page = 1
    store.dispatch('getBoardList', data)
}

// 게시판 이름 획득
function getBoardName(id) {
      switch (parseInt(id)) {
        case 6:
          return '공지게시판';
        case 7:
          return '자유게시판';
        case 8:
          return '질문게시판';
        case 9:
          return '문의게시판';
    }
}

</script>

<style scoped src="../../css/boardlist.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>