<template>
    <!-- 0614 노경호. 
        TODO: 필수입력처리. 미입력시 js로 안적엇다고 출력
        ,정규표현식 처리 -->
    <!-- <form action="" id="registrationForm"> -->
        <!-- 폼박스 넣으니까 오류나는데 이것도 고쳐야함 : 해결완료-노경호 -->
        <div class="container">
        <h2>개인정보입력</h2>
        <form @submit.prevent="validateForm">
            <div class="main_title">
                <!-- 이름 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">이름 <span>*</span></div>
                    </div>
                    <div class="content">
                        <input type="text" v-model="formData.u_name" autoComplete="off">
                        <div class="error-message" v-if="errors.u_name">이름을 입력해주세요.</div>
                    </div>
                </div>
                <!-- 생년월일 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">생년월일 <span>*</span></div>
                    </div>
                    <div class="content">
                        <input type="date" v-model="formData.birth_at" @input="chkBirth">
                        <div class="error-message" v-if="errors.birth_at">생년월일을 입력해주세요.</div>
                    </div>
                </div>
                <!-- 아이디 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">아이디 <span>*</span></div>
                    </div>
                    <div class="content">
                        <input type="text" v-model="formData.u_id" autoComplete="off">
                        <button class="check" type="button">중복확인</button>
                        <div class="error-message" v-if="errors.u_id">아이디를 입력해주세요.</div>
                    </div>
                </div>
                <!-- 비밀번호 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">비밀번호 <span>*</span></div>
                    </div>
                    <div class="content">
                        <input type="password" v-model="formData.u_password" autoComplete="off">
                        <div class="error-message" v-if="errors.u_password">비밀번호를 입력해주세요.</div>
                    </div>
                </div>
                <!-- 비밀번호 확인 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">비밀번호 확인 <span>*</span></div>
                    </div>
                    <div class="content">
                        <input type="password" v-model="formData.password_chk" autoComplete="off">
                        <div class="error-message" v-if="errors.password_match">비밀번호가 일치하지 않습니다.</div>
                    </div>
                </div>
                <!-- 주소 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">주소 <span>*</span></div>
                    </div>
                    <div class="content_address">
                        <input type="text" id="u_post" name="u_post" readonly v-model="postcode" class="input1" placeholder="우편번호">
                        <button type="button" class="address_btn" @click="kakaoPostcode" id="post_search">주소검색</button>
                        <input type="text" name="u_address" id="u_address" class="input2" v-model="address" readonly @click="kakaoPostcode">
                        <input type="text" class="input3" name="u_detail_address" id="u_detail_address" v-model="detailAddress" autoComplete="off">
                        <div class="error-message" v-if="errors.u_address">주소를 입력해주세요.</div>
                    </div>
                </div>
                <!-- 전화번호 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">전화번호 <span>*</span></div>
                    </div>
                    <div class="pon_content">
                        <input type="text" class="input1" name="u_phone_num" id="u_phone_num" placeholder="010-1234-5678" v-model="formData.u_phone_num" autoComplete="off">
                        <div class="error-message" v-if="errors.u_phone">전화번호를 입력해주세요.</div>
                    </div>
                </div>
                <!-- 닉네임 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">닉네임 <span>*</span></div>
                    </div>
                    <div class="content">
                        <input type="text" v-model="formData.u_nickname" autoComplete="off">
                        <button class="check" type="button">중복확인</button>
                        <div class="error-message" v-if="errors.u_nickname">닉네임을 입력해주세요</div>
                    </div>
                </div>
                <!-- 성별 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">성별 <span>*</span></div>
                    </div>
                    <div class="radio-box">
                        <div class="select_gender">
                            <label for="male">남자</label>
                            <input type="radio" name="gender" id="male" value="남자" v-model="formData.gender">
                        </div>
                        <div>
                            <label for="female">여자</label>
                            <input type="radio" name="gender" id="female" value="여자" v-model="formData.gender">
                        </div>
                    </div>
                    <div class="error-message" v-if="errors.gender">성별을 선택해주세요.</div>
                </div>
            
                <div class="buttons">
                    <button class="cancel" type="button" @click="$router.back()">취소</button>
                    <button class="complete" type="submit">다음단계</button>
                </div>
            </div>
        </form>
    </div>
    <!-- </form> -->
</template>
<script setup>  
import { ref } from 'vue';

const address = ref('');
const detailAddress = ref('');
const postcode = ref('');


//  formData -> 객체 
//  각 필드는 사용자 입력 폼에서 제출되거나 수정될 데이터를 저장하는 데 사용된다.
const formData = ref({
    u_name: '',
    birth_at: '',
    u_id: '',
    u_password: '',
    password_chk: '',
    u_phone_num: '',
    u_nickname: '',
    gender: ''
});

const errors = ref({
    u_name: false,
    birth_at: false,
    u_id: false,
    u_password: false,
    password_match: false,
    u_address: false,
    u_phone: false,
    u_nickname: false,
    gender: false
});

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
            document.querySelector('#u_detail_address').focus();
        }
    }).open();
}

// 전화번호 합쳐서 데이터 전송
function updatePhoneNumber() {
    // 선택한 번호 가져오기
    var selectedPrefix = document.getElementById("first_num").value;

    // 입력한 번호 가져오기
    var middleNumber = document.getElementById("middle_num").value;
    var lastNumber = document.getElementById("last_num").value;

    // 양식 조합
    var formattedPhoneNumber = selectedPrefix + "-" + middleNumber + "-" + lastNumber;

    // 결과를 입력 필드에 넣기
    document.getElementById("phone_num").value = formattedPhoneNumber;
}

// 입력 필드의 변경을 감지하여 자동으로 전화번호를 업데이트
var inputs = document.querySelectorAll('.phone');
inputs.forEach(input => {
    input.addEventListener('input', updatePhoneNumber);
});

function validateForm() {
    // 유효성 검사 조건 -> 비어있는지 check
    errors.value = {
        u_name: formData.value.u_name === '',
        birth_at: formData.value.birth_at === '',
        : formData.value.u_id === '',
        u_password: formData.value.u_password === '',
        password_match: formData.value.u_password !== formData.value.password_chk,
        u_address: address.value === '', // Validate address
        u_phone: formData.value.u_phone_num === '',
        u_nickname: formData.value.u_nickname === '',
        gender: formData.value.gender === ''
    };

    // Check if there are any errors
    const hasErrors = Object.values(errors.value).some(error => error);

    if (!hasErrors) {
        console.log('Form Data:', formData.value);
        // 여기에서 실제로 서버에 데이터를 보내거나 다음 단계로 넘어갈 수 있습니다.
    }
}



</script>
<style scoped src="../../css/regist.css">
    
</style>