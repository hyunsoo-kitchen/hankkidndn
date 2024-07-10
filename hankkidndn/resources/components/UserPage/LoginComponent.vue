<template>
    <div class="login_content">
        <h2 class="login_title">로그인/회원가입</h2>
            <div class="main_login">
                <form id="loginForm">
                    <div class="id">
                        <label class="username" for="u_id">아이디</label>
                        <input class="user-name" type="text" id="u_id" name="u_id">
                    </div>
                    <div class="pass">
                        <label class="userpass" for="u_password">비밀번호</label>
                        <input class="user-pass" type="password" id="u_password" name="u_password">
                    </div>
                    <div class="button">
                        <button type="button" @click="$store.dispatch('login')" class="login">로그인</button>
                        <button  @click="$router.push('/regist/agree')"class="register" type="button">회원가입</button>
                    </div>
                </form>
                <div class="kakao-btn">
                    <a href="/api/login/kakao"><img class="btn-img" src="../../../public/img/kakao_login_medium_wide.png"></a>
                     <!-- <button type="button" @click="$store.dispatch('test')">카카오</button> -->
                      <!-- 카카오 로그인 클릭시 모달창 생성 -->
                    <!-- <button class="kakao" type="button" @click="handleKakaoButtonClick"> -->
                        <!-- <img class="btn-img" src="../../../public/img/kakao_login_medium_wide.png"> -->
                    <!-- </button> -->
                </div>
            </div>
    </div>
    <!-- 모달창 -->
    <!-- <div v-if="isModalVisible" @click.self="closeModal" class="modal-overlay">
        <div class="kakao_modal">
            <p>카카오 로그인은 업데이트 예정입니다!</p>
            <p>2024년 7월 3차 발표에서 만나요!</p>
            <button @click="closeModal">닫기</button>
        </div>
    </div> -->
    <!-- 엔터키 눌러서 로그인 처리 TODO -->
    <div class="modal" v-if="isModalVisible" @click.self="closeModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h3 class="modal-title">알림</h3>
            <button @click="closeModal" class="close">×</button>
          </div>
          <div class="modal-body">
            <p>카카오 로그인은 업데이트 예정입니다!</p>
            <p>2024년 7월 3차 발표에서 만나요 !</p>
          </div>
          <div class="modal-footer">
            <button @click="closeModal" class="btn btn-primary">확인</button>
          </div>
        </div>
      </div>
    </div>

</template>

<script setup>
import { ref } from 'vue';
// import { useStore } from 'vuex';
// import { useRouter } from 'vue-router';

// const form = reactive({
//   u_id: '',
//   u_password: ''
// });

// const store = useStore();
// const router = useRouter();

// 모달창 컨트롤
const isModalVisible = ref(false);

const handleKakaoButtonClick = () => {
  isModalVisible.value = true;
};

const closeModal = () => {
  isModalVisible.value = false;
};


// const handleLogin = () => {
//   try {
//     store.dispatch('login', form);
//   } catch (error) {
//     console.error('Login failed', error);
//   }

// };

// const handleKakaoButtonClick = () => {
//     // 알림창 출력
//     // alert('카카오 로그인은 업데이트 예정입니다!');
// };

</script>

<style scoped src="../../css/login.css">

</style>