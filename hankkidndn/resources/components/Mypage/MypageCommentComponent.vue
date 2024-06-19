<template>
<div class="container">
            <!-- 헤드 이미지 -->
            <img class="main-img" src="../../../public/img/my_page.png">
            <h2 class="page_title">마이페이지</h2>
            <div class="main_container">
                <div class="sub_title">
                    <div @click="$router.push('/mypage')" class="sub_title_content title_none_select">내 레시피</div>
                    <div @click="$router.push('/mypage/comments')" class="sub_title_content title_select">내 댓글</div>
                    <div @click="$router.push('/mypage/update')" class="sub_title_content title_none_select">개인정보수정</div>
                </div>
                <div class="main_content">
                    <!-- 내 레시피 -->
                <div class="main_my_page">
                    <img src="../../../public/img/otterface.png">
                    <h2>{{ $store.state.mypageUserinfo.u_nickname }} 님 안녕하세요.</h2>
                    <div class="main_comment">
                        <p>내가 쓴 글 {{ $store.state.mypageUserinfo.recipe_count }}건</p>
                        <p>내가 쓴 댓글 {{ $store.state.mypageUserinfo.comments_count }}건</p>
                    </div>
                </div>
                <div class="my_comment">
                    <div>받은 댓글</div>
                    <div>내가 쓴 댓글</div>
                    <div></div>
                </div>
                </div>
            </div>
    </div>
</template>
<script setup>
import { computed, onBeforeMount } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

onBeforeMount(() => {
    store.dispatch('getMypageUserInfo');
});
</script>
<style scoped src="../../css/my_comment.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>