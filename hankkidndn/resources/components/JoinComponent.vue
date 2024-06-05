<template>
   <main class="main-container">
       <h2>개인정보 입력</h2>
       <div class="u_name">
           <label for="name">이름:</label>
               <input type="text" id="name" name="name" v-model="name" placeholder="이름을 입력해주세요." required>
               <button type="button" @click="checkDuplicate">중복 확인</button>
       </div>
       <div class="u_id">
           <label for="u_id">아이디:</label>
               <input type="email" id="u_id" name="u_id" placeholder="아이디를 입력해주세요." required>
       </div>
       <div class="u_pw">
           <label for="u_pw">비밀번호:</label>
               <input type="password" id="u_pw" name="u_pw" placeholder="비밀번호를 입력해주세요." required>
       </div>
       <div class="u_pw_chk">
           <label for="u_pw_chk">비밀번호 확인:</label>
               <input type="password" id="u_pw_chk" name="u_pw_chk" placeholder="비밀번호를 확인해주세요." required>
       </div>
       <!-- <div class="u_address">
           <label for="u_address">주소:</label>
               <input type="password" id="u_address" name="u_address" required>
       </div> -->
       <div class="address-form">
        <div class="u_address">
            <label for="zipcode">우편번호:</label>
            <input type="text" id="zipcode" name="zipcode" readonly>
            <button type="button" class="btn-search" onclick="searchAddress()">주소 검색</button>
        </div>
        <div class="u_address">
            <label for="address1">기본주소:</label>
            <input type="text" id="address1" name="address1" placeholder="기본주소" readonly>
        </div>
        <div class="u_address">
            <label for="address2">나머지주소:</label>
            <input type="text" id="address2" name="address2" placeholder="나머지 주소" required>
        </div>
    </div>
       <!-- <div class="u_phone">
           <label for="u_phone">휴대전화:</label>
               <input type="text" id="u_phone" name="u_phone" required>
       </div> -->
       <div class="phone-form">
        <div class="u_phone">
            <label for="phone1">휴대전화:</label>
            <input type="text" id="phone1" name="phone1" value="010" readonly required>
            <input type="text" id="phone2" name="phone2" maxlength="4" required>
            <input type="text" id="phone3" name="phone3" maxlength="4" required>
        </div>
       </div>
       <div class="u_nickname">
           <label for="u_nickname">닉네임:</label>
               <input type="text" id="u_nickname" name="u_nickname"placeholder="닉네임을 확인해주세요"  required>
               <button type="button" @click="checkDuplicate">중복 확인</button>
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
function searchAddress() {
            new daum.Postcode({
                oncomplete: function(data) {
                    document.getElementById('zipcode').value = data.zonecode;
                    document.getElementById('address1').value = data.address;
                    document.getElementById('address2').focus();
                }
            }).open();
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
   margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
   font-family: Arial, sans-serif;
   background-color: #f0f0f0;
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
/* 휴대전화 */
.phone-form {
   padding: 20px;
   width: 400px;
}

.phone-form input[type="text"]:not(:last-child) {
   margin-right: 8px;
}
.main-container {
   background-color: #fff;
   padding: 20px;
   border-radius: 8px;
   box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
   width: 700px;
}
.main-container label {
   display: block;
   margin-bottom: 8px;
   font-weight: bold;
}
</style>
