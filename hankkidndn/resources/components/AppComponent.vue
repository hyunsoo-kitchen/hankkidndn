<template>
    <!-- Header -->
        <HeaderComponent/>
    <!-- Main -->
    <main>
        <router-view></router-view>
    </main>
    <!-- Footer -->
        <FooterComponent/>
</template>
<script setup>
    import HeaderComponent from './CommonPage/HeaderComponent.vue';
    import FooterComponent from './CommonPage/FooterComponent.vue';
</script>
<style>
    
</style>