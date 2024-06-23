<template>
<div class="container">
    <!-- 헤드 이미지 -->
    <img class="main-img" src="../../../public/img/my_page.png">
    <h2 class="page_title">마이페이지</h2>
    <div class="main_container">
        <div class="sub_title">
            <div @click="$router.push('/mypage')" class="sub_title_content title_none_select">내 레시피</div>
            <div @click="$router.push('/mypage/comments')" class="sub_title_content title_none_select">내 댓글</div>
            <div @click="$router.push('/mypage/update')" class="sub_title_content title_select">개인정보수정</div>
        </div>
        <div class="main_content">

            <!-- 내 정보 변경 전 본인인증 -->
            <div class="auth_box" v-if="!isAuthenticated">
                <div class="">
                    <div>비밀번호</div>
                    <input type="password" v-model="u_password">
                </div>
                <button @click="authenticate">인증</button>
            </div>

            <!-- 개인정보 수정 -->
            <div class="update_container" v-if="isAuthenticated">
                <!-- 프로필 사진 등록 -->
                <!-- <div class="">

                </div> -->

                <!-- 비밀번호 수정 -->
                <!-- <div class="">

                </div> -->

                <!-- 주소 수정 -->
                <!-- <div class="">

                </div>
                 -->
                <!-- 휴대폰 번호 수정 -->
                <!-- <div class="">

                </div> -->

                <!-- 닉네임 수정 -->
                <!-- <div class="">

                </div> -->
                <span>테스트</span>
            </div>
        </div>
    </div>
</div>
</template>
<script setup>
import { ref, computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const password = ref('');
const isAuthenticated = computed(() => store.state.isAuthenticated);

const authenticate = () => {
  store.dispatch('authenticate', password.value);
};
</script>
<style scoped src="../../css/my_update.css">
     @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>