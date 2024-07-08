<template>
    <h2>진행중인 이벤트</h2>
    <div class="main">
        <div class="main_box">
            <div class="title">{{ $store.state.eventData.title }}</div>
            <div class="period">
                <div class="start">{{ $store.state.eventData.start_date }}</div>
                <div class="end">{{ $store.state.eventData.end_date }}</div>
            </div>
        </div>
    </div>
    <img  :src="$store.state.eventData.img_path">   
</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';

const store = useStore();
const route = useRoute();

const data = ref('');

onBeforeMount(() => {
    data.value = route.params.id
    store.dispatch('eventdetail', data.value)
});
</script>

<style scoped src="../../css/eventdetail.css">
</style>