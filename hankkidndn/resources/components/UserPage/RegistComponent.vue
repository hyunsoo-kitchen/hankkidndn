<template>
    <!-- <form action="" id="registrationForm"> -->
        <!-- 폼박스 넣으니까 오류나는데 이것도 고쳐야함 -->
        <div class="ccontainer">
            <div class="container">
                <h2>개인정보입력</h2>
                <div class="main_title">
                    <div class="title_content">
                        <div class="title">
                            <div class="title_main">이름 <span>*</span></div>
                        </div>
                        <div class="content">
                        <input type="text">
                        <div></div>
                    </div>
                    </div>
                    <div class="title_content">
                        <div class="title">
                            <div class="title_main">아이디 <span>*</span></div>
                        </div>
                        <div class="content">
                        <input type="text">
                        <button class="check" type="button">중복확인</button>
                    </div>
                    </div>
                    <div class="title_content">
                        <div class="title">
                            <div class="title_main">비밀번호 <span>*</span></div>
                        </div>
                        <div class="content">
                        <input type="text">
                        <div></div>
                    </div>
                    </div>
                    <div class="title_content">
                        <div class="title">
                            <div class="title_main">비밀번호 확인 <span>*</span></div>
                        </div>
                        <div class="content">
                        <input type="text">
                        <div></div>
                    </div>
                    </div>
                    <!-- 
                        <div class="radio-box">
                            <div>
                                <label for="male">남자</label>
                                <input type="radio" name="gender" id="male" value="0">
                            </div>
                            <div>
                                <label for="female">여자</label>
                                <input type="radio" name="gender" id="female" value="1">
                            </div>
                        </div>
                    -->
                    <div class="title_content">
                        <div class="title">
                            <div class="title_main">주소 <span>*</span></div>
                        </div>
                        <div class="content_address">
                        <input type="text" readonly v-model="postcode" class="input1">
                        <button type="button" class="address_btn" @click="kakaoPostcode" id="postcode">주소검색</button>
                        <input type="text" name="address" id="address" class="input2" v-model="address" readonly @click="kakaoPostcode">
                        <input type="text" class="input3" name="address_detail" id="address_detail" v-model="detailAddress">
                    </div>
                    </div>
                    <div class="title_content">
                        <div class="title">
                            <div class="title_main">전화번호 <span>*</span></div>
                        </div>
                        <div class="pon_content">
                            <div class="phone_content">
                            <select name="phone-num" id="phone-num">
                                <option value="010">010</option>
                                <option value="011">011</option>
                            </select>
                            <input class="phone" type="text">
                            <input class="phone" type="text">
                        </div>
                        </div>
                    </div>
                    <div class="title_content">
                        <div class="title">
                            <div class="title_main">닉네임 <span>*</span></div>
                        </div>
                        <div class="content">
                        <input type="text">
                        <button class="check" type="button">중복확인</button>
                    </div>
                    </div>
                    <div class="buttons">
                        <!-- 뷰스타그램에서 type="button" 줘서 일단 줬는데 분석해보고 필요없으면 뺄예정 0613 21:26 노경호 -->
                        <button class="cancel"  type="button" @click="$router.back()">취소</button>
                        <button class="complete"  type="button" @click="$store.dispatch('registration')" >다음단계</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- </form> -->
</template>
<script setup>
import { ref } from 'vue';

const address = ref('');
const detailAddress = ref('');
const postcode = ref('');

// 카카오 주소 API
function kakaoPostcode() {
    new daum.Postcode({
        oncomplete: function(data) {
            // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
            // 각 주소의 노출 규칙에 따라 주소를 조합한다.
            // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
            var addr = ''; // 주소 변수
            var extraAddr = ''; // 참고항목 변수
            //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
            if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                addr = data.roadAddress;
            } else { // 사용자가 지번 주소를 선택했을 경우(J)
                addr = data.jibunAddress;
            }
            // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
            if(data.userSelectedType === 'R'){
                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraAddr !== ''){
                    extraAddr = ' (' + extraAddr + ')';
                }
                // 조합된 참고항목을 해당 필드에 넣는다.
                // document.getElementById("sample6_extraAddress").value = extraAddr;
            } else {
                // document.getElementById("sample6_extraAddress").value = '';
            }
            // 우편번호와 주소 정보를 해당 필드에 넣는다.
            postcode.value = data.zonecode;
            // 주소 필드에 삽입
            address.value = addr;
            // 커서를 상세주소 필드로 이동한다.
            document.querySelector('#address_detail').focus();
        }
    }).open();
}
</script>
<style scoped src="../../css/regist.css">
    
</style>