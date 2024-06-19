<template>
    <div class="container">
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
            </div>
        </div>
    </div>


    <!-- 삭제 모달 -->
    <div v-if="modalFlg">
        <div>정말로 삭제 하시겠습니까?</div>
        <button @click="data.board_type = $store.state.boardDetail.boards_type_id, $store.dispatch('boardDelete', data)">삭제</button>
        <button @click="closeModal()">취소</button>
    </div>
</template>

<script setup>
import { onBeforeMount, reactive, ref } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const store = useStore();
const route = useRoute();
const modalFlg = ref(false);
const data = reactive({
    board_type: null,
    id: route.params.id,
});
// const id = route.params.id

function openModal() {
    modalFlg.value = true
}

function closeModal() {
    modalFlg.value = false
}

onBeforeMount(() => {
    store.dispatch('getBoardDetail', data.id);
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
