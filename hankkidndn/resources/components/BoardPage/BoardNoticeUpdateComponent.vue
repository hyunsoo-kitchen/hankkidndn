<template>
<form id="noticeUpdateForm">
    <div class="container">
        <div class="header">
            <img class="main_img" src="../../../public/img/recipe_order.png">
        </div>
        <div class="main_list">
            <h2>글 수정</h2>
            <hr>
            <input autocomplete="off" name="title" type="text" placeholder="제목을 입력해주세요. (최대 100자까지 작성 가능합니다.)" :value="$store.state.noticeDetail.title">
            <div class="content-box">
                <textarea autocomplete="off" name="content" rows="30" placeholder="내용을 입력해주세요. (최대 1000자까지 작성 가능합니다.)">{{ $store.state.noticeDetail.content }}</textarea>
            </div>
            <div class="buttons">
                <button type="button" @click="$store.dispatch('noticeUpdate', notice_id)" class="complete">수정하기</button>
                <button type="button" @click="$router.back()" class="cancel ">취소</button>
            </div>
        </div>
    </div>
</form>
</template>
<script setup>
import { onBeforeMount, ref } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const store = useStore();
const route = useRoute();
const notice_id = ref(route.params.id);


onBeforeMount(() => {
    store.dispatch('getNoticeUpdate', route.params.id)
})
</script>
<style scoped src="../../css/boardinsert.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>