<template>

</template>
<script setup>
import { onBeforeMount } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

onBeforeMount( async () => {
    await store.dispatch('kakaoLogin')
})
</script>
<style>
    
</style>