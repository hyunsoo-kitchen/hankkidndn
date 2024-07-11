<template>
    <!-- 삭제 모달 창 -->
    <div class="modal" v-show="modalFlg">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">알림</h3>
                    <button type="button" @click="closeModal" class="close">×</button>
                </div>
                <div class="modal-body">
                    <p>정말로 삭제 하시겠습니까?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="$store.dispatch('noticeDelete', $store.state.noticeDetail.id)" class="btn btn-primary">삭제</button>
                    <button type="button" @click="closeModal" class="btn btn-primary1">취소</button>
                </div>
            </div>
        </div>
    </div>

    <!-- 게시글 불러오기 시작 -->
    <div class="container">
        <div class="main_list">
            <div class="main_title">
                <h2 class="title_name">공지사항</h2>
                <div class="buttons">
                    <!-- <div class="btn_grid">
                        <button v-if="$store.state.adminInfo.id == 1" type="button" class="update" @click="$router.push('/board/notice/update/' + $store.state.noticeDetail.id)">수정</button>
                        <button v-if="$store.state.adminInfo.id == 1" type="button" @click="openModal()" class="delete">삭제</button>
                    </div> -->
                </div>
            </div>
            <hr>
            <div class="main_title_content">
                <div class="main_title_grid">
                <h2>{{ $store.state.noticeDetail.title }}</h2>
            </div>
                <div class="main_title_content_title">
                    <p>{{ formatDate($store.state.noticeDetail.created_at) }}</p>
                </div>
                <hr>
                <div class="main_content">
                    <p>{{ $store.state.noticeDetail.content }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onBeforeMount, reactive, ref } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const store = useStore();
const route = useRoute();


// 삭제 모달
const modalFlg = ref(false);

// 삭제 모달 제어
function openModal() {
    modalFlg.value = true
}

function closeModal() {
    modalFlg.value = false
}

onBeforeMount(() => {
    store.dispatch('getNoticeDetail', route.params.id)
});

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleString('ko-KR', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
    }).replace(/\.$/, '');  // 마지막 점 제거
};

</script>
<style scoped src="../../css/boarddetail.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>
