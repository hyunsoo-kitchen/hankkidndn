<template>
    <h2>진행중인 이벤트</h2>

</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();


onBeforeMount(() => {
    store.dispatch('eventdetail', data.id)
});
</script>

<style></style>