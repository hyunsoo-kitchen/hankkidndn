<template>
    <div class="login_content">
        <h2 class="login_title">로그인/회원가입</h2>
            <div class="main_login">
                <div class="id">
                    <label class="username" for="username">아이디</label>
                    <input class="user-name" type="text" id="username" name="username">
                </div>
    
                <div class="pass">
                    <label class="userpass" for="password">비밀번호</label>
                    <input class="user-pass" type="password" id="password" name="password">
                </div>
    
                <div class="button">
                    <button class="login" type="submit">로그인</button>
                    <a class="register" href="./">회원가입</a>
                </div>
    
                <a class="find" href="/">아이디,비밀번호 찾기</a>
    
                <div class="kakao-btn">
                    <button class="kakao" type="submit">
                        <img class="btn-img" src="/kakao_login_medium_wide.png">
                    </button>
                </div>
            </div>
    </div>
</template>

<script setup>

</script>

<style>
    @import url('/hankkidndn/resources/css/login.css');
</style>