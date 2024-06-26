<template>
    <!-- 모달 창 -->
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
            <button @click="insertModalOff" class="btn btn-primary">확인</button>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
        <div class="header">
            <img class="main-img" src="../../../public/img/recipe_order.png">
            <div class="ul-list">
                <ul>
                    <li :class="{ 'active': activeType == 6}" @click="boardTypeMove(6)" class="line">공지게시판</li>
                    <li :class="{ 'active': activeType == 7}" @click="boardTypeMove(7)" class="line">자유게시판</li>
                    <li :class="{ 'active': activeType == 8}" @click="boardTypeMove(8)" class="line">질문게시판</li>
                    <li :class="{ 'active': activeType == 9}" @click="boardTypeMove(9)" class="line">문의게시판</li>
                </ul>
            </div>
        </div>
        <div class="main-list">
            <div class="head-title">
                <h3>{{ getBoardName($route.params.id) }}</h3>
                <form @submit.prevent="search">
                    <div class="search-bar">
                        <select v-model="data.searchCriteria" name="search-criteria" id="search-criteria">
                            <option value="title">제목</option>
                            <option value="nickname">닉네임</option>
                        </select>
                        <input v-model="data.search" type="text" placeholder="검색어를 입력하세요">
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
                <div class="list-day">{{ formatDate(item.created_at) }}</div>
            </div>
            <div class="btn-box">
                <!-- 클릭시 글쓰기 페이지로 이동 -->
                <button v-if="$store.state.authFlg" @click="$router.push('/board/insert')" class="text-btn" type="button">글쓰기</button>
                <button v-if="!$store.state.authFlg" @click="insertModalOn()" class="text-btn" type="button">글쓰기</button>
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
import { onBeforeMount, reactive, ref, watch } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

    
const store = useStore();
const route = useRoute();
const insertModal = ref(false);
let page = ref([]);
const data = reactive({
    board_type: '',
    page: '',
    searchCriteria: 'title', // 기본 검색 기준
    search: '' // 검색어 입력
});
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
    activeType.value = route.params.id
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


// 검색 기준과 텍스트에 따라 검색을 수행하는 함수를 구현합니다.
function search() {
    data.page = 1; // 검색 시 페이지를 1로 초기화합니다.
    data.board_type = route.params.id;
    store.dispatch('searchBoards', data);
    // router.push({ path: `/search/board/${data.board_type}/${data.search}`, query: { page: data.page, searchCriteria: data.searchCriteria } });
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
    }).replace(/\.$/, '');  // 마지막 점제거
};



</script>

<style scoped src="../../css/boardlist.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>