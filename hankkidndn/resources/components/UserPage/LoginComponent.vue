<template>
    <div class="login_content">
        <h2 class="login_title">로그인/회원가입</h2>
            <div class="main_login">
                <form id="loginForm">
                    <div class="id">
                        <label class="username" for="u_id">아이디</label>
                        <input class="user-name" type="text" id="u_id" name="u_id" v-model="form.u_id">
                    </div>
                    <div class="pass">
                        <label class="userpass" for="u_password">비밀번호</label>
                        <input class="user-pass" type="password" id="u_password" name="u_password" v-model="form.u_password">
                    </div>
                    <div class="button">
                        <button @click="handleLogin" class="login" type="button">로그인</button>
                        <button @click="$router.push('/regist/agree')"class="register" type="button">회원가입</button>
                    </div>
                </form>
                <div class="kakao-btn">
                    <button class="kakao" type="button" @click="handleKakaoButtonClick">
                        <!-- <img class="btn-img" src="../../../public/img/kakao_login_medium_wide.png"> -->
                        <div class="kakao_modal">
                            <p>카카오 로그인은 업데이트 예정입니다!</p>
                            <p>2024년 7월 3차 발표에서 만나요!</p>
                            <button>닫기</button>
                        </div>
                    </button>
                </div>
            </div>
    </div>
    <!-- 엔터키 눌러서 로그인 처리 TODO -->
</template>

<script setup>
import { reactive } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const form = reactive({
  u_id: '',
  u_password: ''
});

const store = useStore();
const router = useRouter();

const handleLogin = () => {
  try {
    store.dispatch('login', form);
  } catch (error) {
    console.error('Login failed', error);
  }

};

const handleKakaoButtonClick = () => {
    // 알림창 출력
    // alert('카카오 로그인은 업데이트 예정입니다!');
};

</script>

<style scoped src="../../css/login.css">

</style>