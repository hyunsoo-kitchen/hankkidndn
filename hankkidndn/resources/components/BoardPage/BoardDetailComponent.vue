<template>
    <div class="container">
         <!-- 삭제 모달 -->
        <div v-if="modalFlg" class="delete-modal">
            <div class="modal-title">정말로 삭제 하시겠습니까?</div>
            <div class="delete-btn">
                <button type="button" @click="$store.dispatch('boardDelete', $store.state.boardDetail.id)">삭제</button>
                <button type="button" @click="closeModal()">취소</button>
            </div>
        </div>
        <div class="main_list">
            <div class="main_title">
                <h2 class="title_name">{{ getBoardName($store.state.boardDetail.boards_type_id) }}</h2>
                <div class="buttons">
                    <button type="button" class="update" @click="$router.push('/board/update/' + $store.state.boardDetail.id)">수정</button>
                    <button type="button" @click="openModal()" class="delete">삭제</button>
                </div>
            </div>
            <hr>
            <div class="main_title_content">
                <h2>{{ $store.state.boardDetail.title }}</h2>
                <div class="main_title_content_title">
                    <p>{{ $store.state.boardDetail.created_at }}</p>
                    <p class="name">{{ $store.state.boardDetail.u_nickname }}</p>
                </div>
                <hr>
                <div class="main_content">
                    <div class="image-container">
                        <img v-for="(item, index) in $store.state.boardImg" :key="index" :src="item.img_path">
                    </div>
                    <p>{{ $store.state.boardDetail.content }}</p>
                </div>
                <div class="comment-section">
                    <!-- 댓글 불러오기 시작 -->
                    <div v-if="$store.state.commentData" v-for="(item, index) in $store.state.commentData" :key="index" class="comment">
                        <div class="comment-header">
                            <p class="comment-author">{{ item.u_nickname }}</p>
                            <p class="comment-date">{{ item.created_at }}</p>
                            <button v-if="$store.state.userInfo.id == item.user_id" type="button">수정</button>
                            <button v-if="$store.state.userInfo.id == item.user_id" type="button">삭제</button>
                        </div>
                        <p class="comment-content">{{ item.content }}</p>
                        <div class="comment-actions">
                            <!-- 아래 답글 버튼 누를경우 해당 댓글 밑에 입력창 생성 -->
                            <button type="button" @click="cocomentOn(item.id)">답글</button>
                            <button type="button" class="like-button">{{ item.like_chk }}<img src="../../../../hankkidndn/public/img/like.png"></button>
                            <p>{{ item.likes_num }}</p>
                        </div>
                        <!-- 대댓글 불러오기 시작 -->
                        <div v-for="(item2, index2) in $store.state.cocommentData" :key="index2">
                            <div v-if="item2.cocomment == item.id" class="comment">
                                <div class="comment-header">
                                    <p class="comment-author">{{ item2.u_nickname }}</p>
                                    <p class="comment-date">{{ item2.created_at }}</p>
                                </div>
                                <p class="comment-content">{{ item2.content }}</p>
                                <div class="comment-actions">
                                    <button type="button" class="like-button">{{ item2.like_chk }}<img src="../../../../hankkidndn/public/img/like.png"></button>
                                    <p>{{ item2.likes_num }}</p>
                                </div>
                            </div>
                        </div>
                        <div v-if="cocomentFlg && item.id == commentId" class="comment-form">
                            <form id="boardCocomment">
                                <input name="content" type="text" placeholder="댓글" class="comment-input" v-model="cocomment">
                                <button type="button" @click="$store.dispatch('cocomentInsert', item.id), cocomment = '', cocomentOff()" class="comment-submit">답글</button>
                            </form>
                        </div>
                    </div>
                    <form id="boardComment">
                        <div v-if="$store.state.authFlg" class="comment-form">
                            <input @click="cocomentFlg = false" type="text" name="content" placeholder="댓글" class="comment-input" required v-model="comment">
                            <button type="button" @click="$store.dispatch('commentInsert', data.id), comment = '';" class="comment-submit">댓글</button>
                        </div>
                        <div v-else class="comment-form">
                            <div class="comment-input">로그인 후 댓글을 작성해주세요</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onBeforeMount, reactive, ref } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const comment = ref('');
const cocomment = ref('');
const commentId = ref();
const store = useStore();
const route = useRoute();
const modalFlg = ref(false);
const cocomentFlg = ref(false);
const data = reactive({
    board_type: null,
    id: route.params.id,
});


function openModal() {
    modalFlg.value = true
}

function closeModal() {
    modalFlg.value = false
}

// 답글 창 생성 기능
function cocomentOn(id) {
    commentId.value = id;
    cocomentFlg.value = true;
}

// 답글 창 취소 기능
function cocomentOff() {
    cocomentFlg.value = false;
}
onBeforeMount(() => {
    store.dispatch('getBoardDetail', data.id)
});

// 게시판 이름 설정
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
<style scoped src="../../css/boarddetail.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>
