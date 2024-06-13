<template>
    <!-- Header -->
        <HeaderComponent/>
    <!-- Main -->
    <main>
        <router-view></router-view>
    </main>
    <!-- Footer -->
    <footer>
    </footer>
</template>
<script setup>
    import HeaderComponent from './CommonPage/HeaderComponent.vue';
</script>
<style>
    
</style>