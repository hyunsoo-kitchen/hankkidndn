<template>
    <header>
        <div class="header-container">
          <div class="header-content">
            <img class="img-logo" alt="logo" src="../../../public/img/logo.png">
            <div>
              <router-link to="/main"><h1>한끼든든</h1></router-link>
            </div>
                <div class="btn-group" v-if="!$store.state.authFlg">
                  <button @click="$router.push('/login')" class="header-btn" id="login">
                    <img v-if="flgResizeSmaller1044" src="/img/login.png" alt="login" class="img_size">
                    <span v-if="!flgResizeSmaller1044">로그인</span>
                  </button>
                </div>
                <div class="btn-group" v-if="!$store.state.authFlg">
                  <button @click="$router.push('/regist/agree')" class="header-btn" id="regist">
                    <img v-if="flgResizeSmaller1044" src="/img/regist.png" alt="register" class="img_size">
                    <span v-if="!flgResizeSmaller1044">가입하기</span>
                  </button>
                </div>
                <div class="btn-group" v-if="$store.state.authFlg">
                  <button @click="$router.push('/mypage')" class="header-btn1" id="my_page">
                    <img v-if="flgResizeSmaller1044" src="/img/my_page.png" alt="my_page" class="img_size">
                    <span v-if="!flgResizeSmaller1044" >내 정보</span>
                  </button>
                </div>
                <div class="btn-group" v-if="$store.state.authFlg">
                  <button @click="$store.dispatch('logout')" class="header-btn" id="logout">
                    <img v-if="flgResizeSmaller1044" src="/img/logout.png" alt="logout" class="img_size">
                    <span v-if="!flgResizeSmaller1044" >로그아웃</span>
                  </button>
                </div>
          </div>
        </div>
    </header>
</template>

<script setup>
import { onMounted, onBeforeUnmount, ref } from 'vue';

const flgResizeSmaller1044 = ref(true);

// function displayImage() {
//   const loginImage = document.querySelector('#login');
//   const registImage = document.querySelector('#regist');
//   loginImage.style.display = 'block';
//   registImage.style.display = 'block';
//   loginImage.textContent = "";
//   registImage.textContent = "";
//   loginImage.innerHTML = '<img src="/login.png" alt="login">';
//   registImage.innerHTML = '<img src="/regist.png" alt="register">';
// }
// function closeImage() {
//   const loginImage = document.querySelector('#login');
//   const registImage = document.querySelector('#regist');
//   loginImage.style.display = 'block';
//   registImage.style.display = 'block';
//   loginImage.textContent = "로그인";
//   registImage.textContent = "가입하기";
// }

// 화면 크기 변경을 감지하는 함수
function handleResize() {
  if (window.innerWidth <= 1044) {
    flgResizeSmaller1044.value = true;
  } else {
    flgResizeSmaller1044.value = false;
  }
}

// 컴포넌트가 마운트될 때 이벤트 리스너를 추가하고 초기 상태를 설정
onMounted(() => {
  window.addEventListener('resize', handleResize);
  handleResize();
});

// 컴포넌트가 언마운트될 때 이벤트 리스너를 제거
onBeforeUnmount(() => {
  window.removeEventListener('resize', handleResize);
});

</script>

<style scoped src="../../css/header.css">
    
</style>