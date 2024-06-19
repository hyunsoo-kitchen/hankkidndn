<template>
    <div class="container">
        <!-- 헤드 이미지 -->
        <img class="main-img" src="../../../public/img/my_page.png">
        <h2 class="page_title">마이페이지</h2>
        <div class="main_container">
            <div class="sub_title">
                <div class="sub_title_content title_none_select">개인정보수정</div>
                <div class="sub_title_content title_select">내 레시피</div>
                <div class="sub_title_content title_none_select">내 댓글</div>
            </div>
            <div class="main_content" v-if="$store.state.mypageUserinfo.length > 0">
                <!-- userInfo는 배열이 아닌 객체이므로 v-for 대신 직접 접근 -->
                <div class="main_my_page">
                    <!-- <img> -->
                    <h2>{{ $store.state.mypageUserinfo.u_nickname }} 님 안녕하세요.</h2>
                    <div class="main_comment">
                        <p>내가 쓴 글 {{ $store.state.mypageUserinfo.recipe_count }}건</p>
                        <p>내가 쓴 댓글 {{ $store.state.mypageUserinfo.comments_count }}건</p>
                    </div>
                </div>
                <div class="comment_list">
                    <!-- 내 댓글 목록 또는 추가적인 컴포넌트 -->
                </div>
            </div>
            <div v-else>
                <!-- 데이터 로딩 중 표시 -->
                <p>Loading...</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onBeforeMount } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

onBeforeMount(() => {
    if (store.state.mypageUserinfo.length < 1) {
        store.dispatch('getMypageUserInfo').then(() => {
            // 데이터가 로드된 후 처리할 작업
        });
    }
});
</script>

<style scoped src="../../css/my_recipe.css">
     @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>
