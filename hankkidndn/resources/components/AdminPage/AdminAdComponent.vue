<template>
    <div class="head_container">
        <div class="head_logo">
            <img class="img-logo" alt="logo" src="../../../public/img/logo.png">
        </div>
        <div class="head_title">한끼든든</div>
        <div></div>
        <div>
            <p>admin0001</p>    
        </div>
        <div>
            <button @click="$store.dispatch('adminLogout')" type="button" >로그아웃</button>
        </div>
    </div>

    <div class="body_container">
        <div class="category">
            <button class="category_btn">대시보드</button>
            <button class="category_btn">공지사항</button>
            <button class="category_btn">사용자 관리</button>
            <button class="category_btn">컨텐츠 관리</button>
            <button class="category_btn">광고, 캠페인 관리</button>
            <button class="category_btn">통계</button>
        </div>
    </div>
</template>
<script setup>

</script>
<style scoped src="../../css/admin_content.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>