<template>
    <div class="container">
        <div class="main_list">
            <div class="main_title">
                <h2 class="title_name">작성게시판</h2>
                <div class="buttons">
                    <button class="update" @click="goToEditPage">수정</button>
                    <button class="delete" @click="deleteBoard">삭제</button>
                </div>
            </div>
            <hr>
            <div class="main_title_content">
                <h2>{{ boardDetail.title }} </h2>
                <div class="main_title_content_title">
                    <p>{{ boardDetail.created_at }}</p>
                    <p class="name">{{ boardDetail.user_name }}</p>
                </div>
                <hr>
                <div class="main_content">
                    <p>{{ boardDetail.content }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';

export default {
    computed: {
        ...mapState({
            boardDetail: state => state.boardDetail
        })
    },
    methods: {
        goToEditPage() {
            const boardId = this.$route.params.id;
            this.$router.push(`/board/edit/${boardId}`);
        },
        deleteBoard() {
            const boardId = this.$route.params.id;
            this.$store.dispatch('deleteBoard', boardId)
                .then(() => {
                    alert('게시글이 삭제되었습니다.');
                    this.$router.push('/board');
                })
                .catch(error => {
                    console.log(error.response.data);
                    alert('게시글 삭제에 실패했습니다. (' + error.response.data.code + ')');
                });
        }
    }
};
</script>
<style scoped src="../../css/boarddetail.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>
