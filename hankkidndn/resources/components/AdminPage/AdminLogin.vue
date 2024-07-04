<template>
    <div class="login_content">
        <h2 class="login_title">관리자 로그인</h2>
            <div class="main_login">
                <form id="loginForm">
                    <div class="id">
                        <label class="username" for="u_id">아이디</label>
                        <input class="user-name" type="text" id="u_id" name="u_id">
                    </div>
                    <div class="pass">
                        <label class="userpass" for="u_password">비밀번호</label>
                        <input class="user-pass" type="password" id="u_password" name="u_password">
                    </div>
                </form>
                    <div class="button">
                        <button type="button" @click="$store.dispatch('login')" class="login">로그인</button>
                    </div>
            </div>
    </div>   
        
    
</template>

<script setup>

</script>

<style scoped src="../../css/adminlogin.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>