<template>
    <!-- 모달 창 -->
    <div class="modal" v-show="modalFlg">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">알림</h3>
                    <button @click="closeModal()" class="close">×</button>
                </div>
                <div class="modal-body">
                <p>날짜와 이미지를 확인해주세요</p>
                    </div>
                    <div class="modal-footer">
                    <button @click="closeModal()" class="btn btn-primary">확인</button>
                </div>
            </div>
        </div>
    </div>
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
            <button class="category_btn" @click="$router.push('/admindashboard')">대시보드</button>
            <button class="category_btn" @click="$router.push('/adminnotice?page=1')">공지사항</button>
            <button class="category_btn" @click="$router.push('/adminuserfind')">사용자 관리</button>
            <button class="category_btn" @click="$router.push('/admincontentcontroll')">컨텐츠 관리</button>
            <button class="category_btn" @click="$router.push('/adminad')">광고 관리</button>
            <button class="category_btn" @click="$router.push('/adminevent?page=1')">이벤트 관리</button>
        </div>
        <div v-if="!createFlg">
            <div class="event-header">
                <div>이벤트 페이지</div>
                <div class="pointer" @click="createFlgOn();">이벤트 작성</div>
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
                        <button :class="{ activePage: page_num === $store.state.progressEventPagination.current_page }" class="number" @click="pageMove(page_num)">{{ page_num }}</button>
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
        <div v-if="createFlg" class="cook_list">
            <form id="eventFormData">
                <div class="cook-btn">
                    <h2>이벤트 작성</h2>
                </div>
                <div class="title_content">
                    <input autocomplete="off" name="title" class="event_title" type="text" placeholder="제목. (최대 100자까지 작성 가능합니다.)">
                    <div class="content_box">
                        <div class="event_box">
                            <div class="title">
                                <div class="title_main">이벤트 시작일<span>*</span></div>
                            </div>
                            <div class="content">
                                <input class="input_box" type="date" v-model="formData.start_at" @blur="eventStartBlur(formData.start_at)" name="start_at">
                                <div :class="errorStyle.start_at" >{{ flgText.start_at }}</div>
                            </div>
                        </div>
                        <div class="event_box">
                            <div class="title">
                            <div class="title_main">이벤트 종료일<span>*</span></div>
                            </div>
                            <div class="content">
                                <input class="input_box" type="date" v-model="formData.end_at" @blur="eventEndBlur(formData.end_at)" name="end_at">
                                <div :class="errorStyle.end_at" >{{ flgText.end_at }}</div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div>
                        <div v-if="thumbImg == ''" class="font-red program-aline">썸네일 이미지를 넣어주세요.</div>
                        <div class="content_list">
                            <div class="header-box">
                                <label>
                                    <div class="ad-img-btn cursor">이미지 파일 선택</div>
                                    <input required hidden name="thumbnail" type="file" accept="image/*" @change="eventThumbImg($event)" >
                                </label>
                            </div>
                            <img :src="thumbImg">
                        </div>
                    </div>
                    <div>
                        <div v-if="imagePreview == ''" class="font-red program-aline">이벤트 이미지를 넣어주세요.</div>
                        <div class="content_list">
                            <div class="header-box">
                                <label>
                                    <div class="ad-img-btn cursor" >이미지 파일 선택</div>
                                    <input required hidden name="file" type="file" accept="image/*" @change="eventImg($event)" >
                                </label>
                            </div>
                            <img :src="imagePreview">
                        </div>
                    </div>
                    <div>
                        <button v-if="errorFlg.start_at && errorFlg.end_at" @click="$store.dispatch('eventInsert'); createFlgOff(); " type="button">저장</button>
                        <button class="btn" v-else @click="openModal()">저장</button>
                        <button class="btn" @click="createFlgOff()" type="button" id="cancel">취소</button>
                    </div>
                </div>
            </form>
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
const imagePreview = ref('');
const thumbImg = ref('');
const createFlg = ref(false);
const modalFlg = ref(false);
const progressFlg = ref(true);
const finishFlg = ref(false);
const formData = reactive({
    start_at: '',
    end_at: '',
});

const flgText = reactive({
    start_at: '',
    end_at: '',
});

const errorStyle = reactive({
    start_at: '',
    end_at: '',
});

const errorFlg = reactive({
    start_at: false,
    end_at: false,
});

// 페이지 네이션
// watch로 route.query.page(router.js의 현재페이지) 가 바뀔때마다 안에 함수들을 실행
watch(() => route.query.page, (newPage) => {
    page.value = newPage;
    pagination(newPage);
    finishPagination(newPage);
    store.dispatch('getEventData', page.value);
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
        store.dispatch('getEventData', nowPage)
        pagination(route.query.page)
    }
}

// page 이동 버튼
function finishPageMove(nowPage) {
    if(nowPage >= 1 && nowPage <= store.state.finishEventPagination.last_page) {
        page.value = nowPage;
        store.dispatch('getEventData', nowPage)
        pagination(route.query.page)
    }
}

// 썸네일 이미지 미리보기
function eventThumbImg(img) {

    const file = img.target.files[0];

    // 취소 누를경우 빈배열 생기는걸 방지
    if (!file) return;

    // 선택한 파일의 URL 생성
    thumbImg.value = URL.createObjectURL(file);
}

// 이벤트 이미지 미리보기
function eventImg(img) {

    const file = img.target.files[0];

    // 선택한 파일의 URL 생성
    imagePreview.value = URL.createObjectURL(file);
}

function createFlgOn() {
    createFlg.value = true;
}

function createFlgOff() {
    createFlg.value = false;
}

// 이벤트 시작일 정규표현식 체크
function eventStartBlur(date) {
    const chkBirth = /^\d{4}-\d{2}-\d{2}$/;

    if(chkBirth.test(date)) {

        // 날짜 확인
        const inputDate = new Date(date);
        const today = new Date();
        
        // 오늘 이후 날짜 입력시 체크
        if (inputDate < today) {
            flgText.start_at = '시작일은 오늘 날짜 이후여야 합니다.';
            errorStyle.start_at = 'error-message';
            errorFlg.start_at = false;
        } else {
            flgText.start_at = '';
            errorFlg.start_at = true;
        }
    } else {
        flgText.start_at = '날짜를 정확히 입력해주세요.';
        errorStyle.start_at = 'error-message';
        errorFlg.start_at = false;
    }
}

// 이벤트 종료기간 정규표현식 체크
function eventEndBlur(date) {
    const chkBirth = /^\d{4}-\d{2}-\d{2}$/;

    if(chkBirth.test(date)) {

        // 날짜 확인
        const startDate = new Date(formData.start_at)
        const inputDate = new Date(date);
        const today = new Date();

        // 오늘 이후 날짜 입력시 체크
        if (inputDate < startDate) {
            flgText.end_at = '종료일은 시작 날짜 이후여야 합니다.';
            errorStyle.end_at = 'error-message';
            console.log(flgText.end_at);
            errorFlg.end_at = false;
        } else if(inputDate < today) {
            flgText.end_at = '종료일은 오늘 날짜 이후여야 합니다.';
            console.log(flgText.end_at);
            errorStyle.end_at = 'error-message';
            errorFlg.end_at = false;
        } else {
            flgText.end_at = '';
            errorFlg.end_at = true;
        }
    } else {
        flgText.end_at = '날짜를 정확히 입력해주세요.';
        errorStyle.end_at = 'error-message';
        errorFlg.end_at = false;
    }
}
// 이벤트 변경
function progressEventOn() {
    progressFlg.value = true;
    finishFlg.value = false;
    store.dispatch('getEventData', 1);
}

function finishEventOn() {
    progressFlg.value = false;
    finishFlg.value = true;
    store.dispatch('getEventData', 1);
}

// 모달창
function openModal() {
    modalFlg.value = true;
}

function closeModal() {
    modalFlg.value = false;
}

onBeforeMount(() => {
    page.value = route.query.page;
    store.dispatch('getEventData', page.value);
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
<style scoped src="../../css/admin_event.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>