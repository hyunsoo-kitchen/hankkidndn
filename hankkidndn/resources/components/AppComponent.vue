<template>
    <!-- Header -->
    <header>
        <div class="header-container">
          <div class="header-content">
            <img class="img-logo" alt="logo" src="/logo.png">
            <div>
              <router-link to="/main"><h1>한끼든든</h1></router-link>
            </div>
                <div class="btn-group" v-if="!$store.state.authFlg">
                  <button @click="$router.push('/login')" class="header-btn" id="login">로그인</button>
                </div>
                <div class="btn-group" v-if="!$store.state.authFlg">
                  <button @click="$router.push('/registration')" class="header-btn" id="regist">가입하기</button>
                </div>
                <div class="btn-group" v-else>
                  <button @click="$store.dispatch('logout')" class="header-btn myInfo"></button>
                </div>
                <div class="btn-group" v-else>
                  <button @click="$store.dispatch('logout')" class="header-btn" id="logout">로그아웃</button>
                </div>
          </div>
        </div>
    </header>
    <!-- Main -->
    <main>
        <router-view></router-view>
    </main>
    <!-- Footer -->
    <footer>
    </footer>
</template>
<script setup>
import { onMounted, onBeforeUnmount } from 'vue';

function displayImage() {
  const loginImage = document.querySelector('#login');
  const registImage = document.querySelector('#regist');
  loginImage.style.display = 'block';
  registImage.style.display = 'block';
  loginImage.textContent = "";
  registImage.textContent = "";
  loginImage.innerHTML = '<img src="/login.png" alt="login">';
  registImage.innerHTML = '<img src="/regist.png" alt="register">';
}
function closeImage() {
  const loginImage = document.querySelector('#login');
  const registImage = document.querySelector('#regist');
  loginImage.style.display = 'block';
  registImage.style.display = 'block';
  loginImage.textContent = "로그인";
  registImage.textContent = "가입하기";
}

// 화면 크기 변경을 감지하는 함수
function handleResize() {
  if (window.innerWidth <= 1044) {
    displayImage();
  } else {
    closeImage();
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
<style>
    @import url('../css/common.css');
</style>