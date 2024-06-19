<template>
    <div class="container">
         <!-- 삭제 모달 -->
    <div v-if="modalFlg" class="delete-modal">
        <div class="modal-title">정말로 삭제 하시겠습니까?</div>
        <div class="delete-btn">
        <button @click="$store.dispatch('boardDelete', id)">삭제</button>
        <button @click="closeModal()">취소</button>
        </div>
    </div>
        <div class="main_list">
            <div class="main_title">
                <h2 class="title_name">작성게시판</h2>
                <div class="buttons">
                    <button class="update" @click="$router.push('/board/update')">수정</button>
                    <button @click="openModal()" class="delete">삭제</button>
                </div>
            </div>
            
            <hr>
            <div class="main_title_content">
                <h2>{{ $store.state.boardDetail.title }} </h2>
                <div class="main_title_content_title">
                    <p>{{ $store.state.boardDetail.created_at }}</p>
                    <p class="name">{{ $store.state.boardDetail.u_nickname }}</p>
                </div>
                <hr>
                <div class="main_content">
                    <p>{{ $store.state.boardDetail.content }}</p>
                </div>
                <div class="comment-section">
                    <div class="comment">
                    <div class="comment-header">
                    <p class="comment-author">이현수수깡</p>
                    <p class="comment-date">2024-06-19 13:00:02</p>
                </div>
                <p class="comment-content">ㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋㅋ 감사합니다</p>
                <div class="comment-actions">
                <button class="like-button"><img src="../../../../hankkidndn/public/img/like.png"></button>
                <p>60</p>
                </div>
            </div>
            <div class="comment-form">
            <input type="text" placeholder="댓글" class="comment-input"/>
            <button class="comment-submit">댓글</button>
            </div>
        </div>
        </div>
    </div>
</div>

</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const store = useStore();
const route = useRoute();
const modalFlg = ref(false);
const id = route.params.id

function openModal() {
    modalFlg.value = true
}

function closeModal() {
    modalFlg.value = false
}

onBeforeMount(() => {
    store.dispatch('getBoardDetail', id);
});
// import { mapState } from 'vuex';

// export default {
//     computed: {
//         ...mapState({
//             boardDetail: state => state.boardDetail
//         })
//     },
//     methods: {
//         goToEditPage() {
//             const boardId = this.$route.params.id;
//             this.$router.push(`/board/edit/${boardId}`);
//         },
//         deleteBoard() {
//             const boardId = this.$route.params.id;
//             this.$store.dispatch('deleteBoard', boardId)
//                 .then(() => {
//                     alert('게시글이 삭제되었습니다.');
//                     this.$router.push('/board');
//                 })
//                 .catch(error => {
//                     console.log(error.response.data);
//                     alert('게시글 삭제에 실패했습니다. (' + error.response.data.code + ')');
//                 });
//         }
//     }
// };$store.dispatch('getBoardDetail', item.id)
</script>
<style scoped src="../../css/boarddetail.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>
