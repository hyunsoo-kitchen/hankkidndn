<template>
    <div class="body_container">
        <div class="event-header">
            <div>이벤트 페이지</div>
        </div>

        <div class="event-body-header">
            <div class="pointer" @click="progressEventOn()">진행중인 이벤트</div>
            <div class="pointer" @click="finishEventOn()">종료된 이벤트</div>
        </div>

        <div v-show="progressFlg" class="event-container">
            <div class="grid-tem">
            <div @click="$store.dispatch('eventdetail', item.id)" class="event-card" v-for="(item, index) in $store.state.progressEvent" :key="index">
                <img :src="item.thumb_img_path" class="event-card-img">
                <div class="event-card-text">
                    <div>{{ item.title }}</div>
                    <div>{{ item.start_date }} ~ {{ item.end_date }}</div>
                </div>
            </div>
            </div>
            <div class="notice-pagination">
                <button v-if="$store.state.progressEventPagination.current_page !== 1" class="number" @click="pageMove($store.state.progressEventPagination.current_page - 1)">이전</button>
                <div v-for="page_num in pages" :key="page_num">
                    <button class="number" @click="pageMove(page_num)">{{ page_num }}</button>
                </div>
                <button v-if="$store.state.progressEventPagination.current_page < $store.state.progressEventPagination.last_page" class="number" @click="pageMove($store.state.progressEventPagination.current_page + 1)">다음</button>
            </div>
        </div>

        <div v-show="finishFlg" class="event-container">
            <div class="grid-tem">
            <div class="event-card" v-for="(item, index) in $store.state.finishEvent" :key="index">
                <img :src="item.thumb_img_path" class="event-card-img">
                <div class="event-card-text">
                    <div>{{ item.title }}</div>
                    <div>{{ item.start_date }} ~ {{ item.end_date }}</div>
                </div>
            </div>
            </div>
            <div class="notice-pagination">
                <button v-if="$store.state.finishEventPagination.current_page !== 1" class="number" @click="finishPageMove($store.state.finishEventPagination.current_page - 1)">이전</button>
                <div v-for="page_num in pages" :key="page_num">
                    <button class="number" @click="finishPageMove(page_num)">{{ page_num }}</button>
                </div>
                <button v-if="$store.state.finishEventPagination.current_page < $store.state.finishEventPagination.last_page" class="number" @click="finishPageMove($store.state.finishEventPagination.current_page + 1)">다음</button>
            </div>
        </div>
    </div>


</template>
<script setup>
import { onBeforeMount, ref, reactive, watch } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

    
const route = useRoute();
const store = useStore();

const page = ref();
const pages = ref([]);
const progressFlg = ref(true);
const finishFlg = ref(false);

// 페이지 네이션
// watch로 route.query.page(router.js의 현재페이지) 가 바뀔때마다 안에 함수들을 실행
watch(() => route.query.page, (newPage) => {
    page.value = newPage;
    pagination(newPage);
    finishPagination(newPage);
    store.dispatch('getBoardEventData', page.value);
});

function pagination(nowPage) {
    const last_page = store.state.progressEventPagination.last_page;
    const start_page = (Math.ceil(nowPage / 5)) * 5 - 4;
    const max_page = Math.min(start_page + 4, last_page)
    pages.value = [];
    for (let i = start_page; i <= max_page; i++) {
        pages.value.push(i);
    }
}

function finishPagination(nowPage) {
    const last_page = store.state.finishEventPagination.last_page;
    const start_page = (Math.ceil(nowPage / 5)) * 5 - 4;
    const max_page = Math.min(start_page + 4, last_page)
    pages.value = [];
    for (let i = start_page; i <= max_page; i++) {
        pages.value.push(i);
    }
}

// page 이동 버튼
function pageMove(nowPage) {
    console.log(nowPage)
    if(nowPage >= 1 && nowPage <= store.state.progressEventPagination.last_page) {
        page.value = nowPage;
        store.dispatch('getBoardEventData', nowPage)
        pagination(route.query.page)
    }
}

// page 이동 버튼
function finishPageMove(nowPage) {
    if(nowPage >= 1 && nowPage <= store.state.finishEventPagination.last_page) {
        page.value = nowPage;
        store.dispatch('getBoardEventData', nowPage)
        pagination(route.query.page)
    }
}

// 이벤트 변경
function progressEventOn() {
    progressFlg.value = true;
    finishFlg.value = false;
    store.dispatch('getBoardEventData', 1);
}

function finishEventOn() {
    progressFlg.value = false;
    finishFlg.value = true;
    store.dispatch('getBoardEventData', 1);
}

onBeforeMount(() => {
    page.value = route.query.page;
    store.dispatch('getBoardEventData', page.value);
    // 진행중인 이벤트 처리
    let interval = setInterval(() => {
        pagination(route.query.page);
        if(store.state.progressEventPagination.last_page) {
            clearInterval(interval);
        }
    }, 500);
    // 종료된 이벤트 처리
    interval = setInterval(() => {
        finishPagination(route.query.page);
        if(store.state.finishEventPagination.last_page) {
            clearInterval(interval);
        }
    }, 500);
});

</script>
<style scoped src="../../css/eventlist.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>