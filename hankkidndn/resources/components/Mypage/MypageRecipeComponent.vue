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
                <div class="main_content" v-for="userInfo in $store.state.mypageUserinfo">
                    <!-- 내 레시피 -->
                    <div class="main_my_page">
                        <img :src="userInfo.profile">
                        <h2>{{ userInfo.u_nickname }} 님 안녕하세요.</h2>
                        <div class="main_comment">
                            <p>내가 쓴 글 {{ userInfo.recipe_count }}건</p>
                            <p>내가 쓴 댓글 40건</p>
                        </div>
                    </div>
                    <div class="coment_list">
                        
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
    if(store.state.mypageUserinfo.length < 1) {
        store.dispatch('getMypageUserInfo');
    }
});
</script>
<style scoped src="../../css/my_recipe.css">
     @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>