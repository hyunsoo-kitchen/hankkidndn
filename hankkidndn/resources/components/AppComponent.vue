<template>
    <!-- Header -->
    <header>
    <div class="header-container">
      <div class="header-content">
        <img class="img-logo" alt="logo" src="/logo.png">
        <div class="title">
          <router-link to="/main"><h1>한끼든든</h1></router-link>
        </div>
        <div class="btn-group">
            <div v-if="!$store.state.authFlg">
              <button @click="$router.push('/login')" class="header-btn">로그인</button>
            </div>
            <div v-if="!$store.state.authFlg">
              <button @click="$router.push('/registration')" class="header-btn">가입하기</button>
            </div>
            <div v-else>
              <button @click="$store.dispatch('logout')" class="header-btn myInfo"></button>
            </div>
            <div v-else>
              <button @click="$store.dispatch('logout')" class="header-btn">로그아웃</button>
            </div>
        </div>
      </div>
      <!-- <div class="header-nav-content">
        <div>HOME</div>
        <div>RECIP</div>
        <div>BOARD</div>
      </div> -->
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
</script>
<style>
    @import url('../css/common.css');
</style>