<template>
    <div>카카오로그인</div>
</template>
<script setup>
import { onBeforeMount } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

onBeforeMount(() => {
    store.dispatch('kakaoLogin')
})
</script>
<style>
    
</style>