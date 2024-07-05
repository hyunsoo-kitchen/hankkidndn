<template>
    <!-- Header -->
        <HeaderComponent/>
    <!-- Main -->
     <!-- <div v-if="$store.state.modalMessage">
        <h1>테스트트ㅡㅌ</h1>
        <h1 @click="$store.commit('setModalMessage', '')">{{ $store.state.modalMessage }}</h1>
    </div> -->
      <!-- 모달 창 -->
<div class="modal" v-if="$store.state.modalMessage">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title">알림</h3>
                <button @click="$store.commit('setModalMessage', '')" class="close">×</button>
            </div>
            <div class="modal-body">
                {{ $store.state.modalMessage }}
            </div>
            <div class="modal-footer">
                <button @click="$store.commit('setModalMessage', '')"class="btn btn-primary">확인</button>
            </div>
        </div>
    </div>
</div>
    <main>
        <router-view>
        </router-view>
    </main>
    <!-- Footer -->
        <FooterComponent/>

</template>

<script setup>
    import HeaderComponent from './CommonPage/HeaderComponent.vue';
    import FooterComponent from './CommonPage/FooterComponent.vue';
</script>

<style scoped src="../css/app_modal.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>