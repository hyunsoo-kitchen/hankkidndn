<template>
    <div class="login_content">
        <h2 class="login_title">로그인/회원가입</h2>
            <div class="main_login">
                <form @submit.prevent="handleLogin" id="loginForm">
                    <div class="id">
                        <label class="username" for="u_id">아이디</label>
                        <input class="user-name" type="text" id="u_id" name="u_id" v-model="form.u_id">
                    </div>
                    <div class="pass">
                        <label class="userpass" for="u_password">비밀번호</label>
                        <input class="user-pass" type="password" id="u_password" name="u_password" v-model="form.u_password">
                    </div>
                    <div class="button">
                        <button @click="handleLogin" class="login" type="">로그인</button>
                        <button @click="$router.push('/regist/agree')"class="register" type="">회원가입</button>
                    </div>
                </form>
                <div class="kakao-btn">
                    <button class="kakao" type="button">
                        <img class="btn-img" src="../../../public/img/kakao_login_medium_wide.png">
                    </button>
                </div>
            </div>
    </div>
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

const handleLogin = async () => {
  try {
    await store.dispatch('login', form);
    router.push('/main'); 
  } catch (error) {
    console.error('Login failed', error);
  }

};

</script>

<style scoped src="../../css/login.css">

</style>