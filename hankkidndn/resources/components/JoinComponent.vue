<template>
    <header>
       <div class="header-section">
           <!-- 아이콘 영역 -->
           <h2>아이콘</h2>
       </div>
       <div class="header-section MIDDLE">
           <!-- 두 번째 영역 -->
           <h2>한끼 든든</h2>
       </div>
       <div class="header-section">
           <!-- 세 번째 영역 -->
           <h2>LOGIN</h2>
       </div>
   </header>
   <main class="main-container">
       <h2>개인정보 입력</h2>
       <div class="u_name">
           <label for="name">이름:</label>
               <input type="text" id="name" name="name" v-model="name" required>
               <button type="button" @click="checkDuplicate">중복 확인</button>
       </div>
       <div class="u_id">
           <label for="u_id">아이디:</label>
               <input type="email" id="u_id" name="u_id" required>
       </div>
       <div class="u_pw">
           <label for="u_pw">비밀번호:</label>
               <input type="password" id="u_pw" name="u_pw" required>
       </div>
       <div class="u_pw_chk">
           <label for="u_pw_chk">비밀번호 확인:</label>
               <input type="password" id="u_pw_chk" name="u_pw_chk" required>
       </div>
       <div class="u_address">
           <label for="u_address">주소:</label>
               <input type="password" id="u_address" name="u_address" required>
       </div>
       <div class="u_phone">
           <label for="u_phone">휴대전화:</label>
               <input type="text" id="u_phone" name="u_phone" required>
       </div>
       <div class="u_nickname">
           <label for="u_nickname">닉네임:</label>
               <input type="text" id="u_nickname" name="u_nickname" required>
       </div>
   </main>
</template>
<script setup>
import { ref } from 'vue';

const name = ref('');

// JavaScript로 중복 확인을 처리합니다.
function checkDuplicate() {
   // 여기서는 단순 예시로 alert를 통해 결과를 보여줍니다.
alert("입력하신 이름 '" + name.value + "'은(는) 사용 가능합니다.");
}

</script>
<style>
.main-container {
   display: flex;
   flex-direction: column;
   gap: 15px;
   padding: 20px;
}

.u_name, .u_id, .u_pw, .u_pw_chk, .u_address, .u_phone, .u_nickname {
   display: flex;
   align-items: center;
   gap: 10px;
}

label {
   width: 100px;
}

input {
   flex: 1;
   padding: 5px;
}

button {
   padding: 5px 10px;
   cursor: pointer;
}
/* 스타일링을 위한 CSS 코드 */
.header-section {
   width: calc(100% / 3); /* 가로폭을 1/3로 설정 */
   float: left; /* 왼쪽 정렬 */
   box-sizing: border-box; /* padding과 border를 포함한 전체 너비로 설정 */
   padding: 20px; /* 내부 여백 */
   border: 1px solid #ccc; /* 테두리 추가 */
   text-align: center; /* 텍스트 가운데 정렬 */
}
.header-section.middle {
   width: calc(100% / 3 * 2); /* 중앙 영역 너비 늘리기 */
}
body {
   font-family: Arial, sans-serif;
}
/* 이름 */
.form-container {
   display: flex;
   justify-content: center;
   align-items: center;
   height: 100vh;
}
/* 입력 폼 스타일 */
form {
   max-width: 400px;
   margin: 0 auto;
   text-align: center;
}
.flex-container {
   display: flex;
   align-items: center;
   gap: 10px;
}

label {
   display: block;
   margin-bottom: 10px;
}

input[type="text"] {
   width: 100%;
   padding: 10px;
   margin-bottom: 20px;
   box-sizing: border-box;
}

button {
   padding: 10px 20px;
   background-color: #007bff;
   color: #fff;
   border: none;
   cursor: pointer;
}

button:hover {
   background-color: #0056b3;
}

/* 결과 메시지 스타일 */
#result {
   margin-top: 20px;
   font-weight: bold;
}
</style>
