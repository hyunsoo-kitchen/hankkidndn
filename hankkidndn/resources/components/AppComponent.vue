<template>
    <!-- Header -->
    <div v-if="$route.path !== '/admincontentcontroll'">
        <HeaderComponent/>
    </div>
    <!-- Main -->
    <main>
        <router-view></router-view>
    </main>
    <!-- Footer -->
    <div v-if="$route.path !== '/admincontentcontroll'">
        <FooterComponent/>
    </div>
</template>
<script setup>
    import HeaderComponent from './CommonPage/HeaderComponent.vue';
    import FooterComponent from './CommonPage/FooterComponent.vue';
</script>
<style>
    
</style>