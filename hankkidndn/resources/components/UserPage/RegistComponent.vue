<template>
    <div class="container">
        <h2>개인정보입력</h2>
        <form @submit.prevent="validateForm" id="registrationForm">
            <div class="main_title">
                <!-- 이름 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">이름 <span>*</span></div>
                    </div>
                    <div class="content">
                        <input type="text" name="u_name" v-model="formData.u_name" @blur="nameBlur(formData.u_name)" autoComplete="off">
                        <div id="namechk" :class="errorStyle.u_name">{{ flgText.u_name }}</div>
                        <!-- <div class="error-message" v-if="errors.u_name">이름을 입력해주세요.</div> -->
                    </div>
                </div>
                <!-- 생년월일 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">생년월일 <span>*</span></div>
                    </div>
                    <div class="content">
                        <input type="date" name="birth_at" v-model="formData.birth_at" @blur="birthBlur(formData.birth_at)" @input="chkBirth">
                        <div :class="errorStyle.birth_at" >{{ flgText.birth_at }}</div>
                    </div>
                </div>
                <!-- 아이디 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">아이디 <span>*</span></div>
                    </div>
                    <div class="content">
                        <input type="text" name="u_id" v-model="formData.u_id" @blur="idBlur(formData.u_id)" placeholder="영어 대소문자와 숫자를 사용한 6~20글자로 만들어주세요." autoComplete="off">
                        <button @click="$store.dispatch('idCheck', formData.u_id)" class="check" type="button">중복확인</button>
                        <div v-if="formData.u_id === $store.state.userId" :class="errorStyle.u_id">{{ flgText.u_id }}</div>
                    </div>
                </div>
                <!-- 비밀번호 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">비밀번호 <span>*</span></div>
                    </div>
                    <div class="content">
                        <input type="password" name="u_password" @blur="passwordBlur(formData.u_password)" placeholder="영어 대소문자와 숫자, !@#$를 사용한 8~20글자로 만들어주세요." v-model="formData.u_password" autoComplete="off">
                        <div :class="errorStyle.u_password">{{ flgText.u_password }}</div>
                    </div>
                </div>
                <!-- 비밀번호 확인 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">비밀번호 확인 <span>*</span></div>
                    </div>
                    <div class="content">
                        <input type="password" name="password_chk" v-model="formData.password_chk" @blur="passwordChkBlur(formData.password_chk)" autoComplete="off">
                        <div :class="errorStyle.password_chk">{{ flgText.password_chk }}</div>
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
                        <input type="text" class="input3" name="u_detail_address" id="u_detail_address" @blur="addressChkBlur(detailAddress)" v-model="detailAddress" autoComplete="off">
                        <div :class="errorStyle.address">{{ flgText.address }}</div>
                    </div>
                </div>
                <!-- 전화번호 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">전화번호 <span>*</span></div>
                    </div>
                    <div class="pon_content">
                        <input type="text" class="input1" name="u_phone_num" id="u_phone_num" @blur="phoneBlur(formData.u_phone_num)" placeholder="010-1234-5678" v-model="formData.u_phone_num" autoComplete="off">
                        <div :class="errorStyle.u_phone_num">{{ flgText.u_phone_num }}</div>
                    </div>
                </div>
                <!-- 닉네임 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">닉네임 <span>*</span></div>
                    </div>
                    <div class="content">
                        <input type="text" name="u_nickname" v-model="formData.u_nickname" @blur="nicknameBlur(formData.u_nickname)" placeholder="한글,영어,숫자를 사용한 2~10글자로 만들어주세요." autoComplete="off">
                        <button @click="$store.dispatch('nicknameCheck', formData.u_nickname)" class="check" type="button">중복확인</button>
                        <div v-if="formData.u_nickname === $store.state.userNickname" :class="errorStyle.u_nickname">{{ flgText.u_nickname }}</div>
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
                            <input @click="flgText.gender = ''; errors.gender = true;" type="radio" name="gender" id="male" value="0" v-model="formData.gender">
                        </div>
                        <div>
                            <label for="female">여자</label>
                            <input @click="flgText.gender = ''; errors.gender = true;" type="radio" name="gender" id="female" value="1" v-model="formData.gender">
                        </div>
                        <div :class="errorStyle.gender">{{ flgText.gender }}</div>
                    </div>
                </div>
            
                <div class="buttons">
                    <button class="cancel" type="button" @click="$router.back()">취소</button>
                    <button v-if="$store.state.idFlg && $store.state.nicknameFlg && formData.u_nickname == $store.state.userNickname && $store.state.userId == formData.u_id" class="complete" type="submit" @click="handleRegistModal">가입하기</button>
                    <button v-else class="complete" type="button" @click="chkModal()">가입하기</button>
                </div>
            </div>
        </form>
    </div>

<!-- 가입확인 모달 -->
<!-- <div v-if="isModalVisible" class="modal_overlay"  @click.self="closeModal">
    <div>정말로 가입하시겠습니까?</div>
    <div>
        <p>입력하신 정보로 정말 가입하시겠습니까?</p>
    </div>
    <button @click="closeModal">취소</button>
    <button @click="submitRegistration">가입하기</button>
</div> -->

<div class="modal" v-if="isModalVisible">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">알림</h3>
            <button @click="closeModal" class="close">×</button>
        </div>
        <div class="modal-body">
            <p>입력하신 정보로 정말 가입하시겠습니까?</p>
        </div>
        <div class="modal-footer">
            <button @click="closeModal" class="btn btn-primary1">취소</button>
            <button class="btn btn-primary" @click="submitRegistration">가입</button>
        </div>
        </div>
    </div>
</div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const address = ref('');
const detailAddress = ref('');
const postcode = ref('');

// validator 체크용 텍스트
const flgText = reactive({
    u_name: '',
    birth_at: '',
    u_id: '',
    u_password: '',
    password_chk: '',
    u_phone_num: '',
    u_nickname: '',
    gender: '',
    address: '',
});

// validator 체크용 class
const errorStyle = reactive({
    u_name: '',
    birth_at: '',
    u_id: '',
    u_password: '',
    password_chk: '',
    u_phone_num: '',
    u_nickname: '',
    gender: '',
    address: '',
});

//  formData -> 객체 
//  각 필드는 사용자 입력 폼에서 제출되거나 수정될 데이터를 저장하는 데 사용된다.
const formData = reactive({
    u_name: '',
    birth_at: '',
    u_id: '',
    u_password: '',
    password_chk: '',
    u_phone_num: '',
    u_nickname: '',
    gender: '',
    address: '',
});

const errors = reactive({
    u_name: false,
    birth_at: false,
    u_id: false,
    u_password: false,
    password_match: false,
    u_phone: false,
    u_nickname: false,
    gender: false,
    address: false,
});

// 이름 정규표현식 체크
function nameBlur(name) {
    const chkName = /^[가-힣]{1,50}$/u;
    console.log(name)
    if(chkName.test(name)) {
        flgText.u_name = '형식에 맞는 이름입니다.';
        errorStyle.u_name = 'pass-message';
        errors.u_name = true;
    } else {
        flgText.u_name = '이름의 형식에 맞게 기입해 주세요.';
        errorStyle.u_name = 'error-message';
        errors.u_name = false;
    }
}

// 비밀번호 정규표현식 체크
function passwordBlur(password) {
    const chkPassword = /^[a-zA-Z0-9!@#$]{8,20}$/;
    console.log(password)
    if(chkPassword.test(password)) {
        flgText.u_password = '사용가능한 비밀번호 입니다.';
        errorStyle.u_password = 'pass-message';
        errors.u_password = true;
    } else {
        flgText.u_password = '영어 대소문자와 숫자, !@#$를 사용한 8~20글자로 만들어주세요.';
        errorStyle.u_password = 'error-message';
        errors.u_password = false;
    }
}

// 닉네임 정규표현식 체크
function nicknameBlur(nickname) {
    const chkNickname = /^[가-힣a-zA-Z0-9]{2,10}$/u;
    console.log(nickname)
    if(chkNickname.test(nickname)) {
        flgText.u_nickname = '사용가능한 닉네임 입니다.';
        errorStyle.u_nickname = 'pass-message';
        errors.u_nickname = true;
    } else {
        flgText.u_nickname = '닉네임은 한글,영어,숫자를 사용한 2~10글자로 만들어주세요.';
        errorStyle.u_nickname = 'error-message';
        errors.u_nickname = false;
    }
}

// 생년월일 정규표현식 체크
function birthBlur(birth) {
    const chkBirth = /^\d{4}-\d{2}-\d{2}$/;
    console.log(birth)
    if(chkBirth.test(birth)) {

        // 날짜 확인
        const inputDate = new Date(birth);
        const today = new Date();
        
        // 오늘 이후 날짜 입력시 체크
        if (inputDate > today) {
            flgText.birth_at = '생년월일은 오늘 날짜 이전이어야 합니다.';
            errorStyle.birth_at = 'error-message';
            errors.birth_at = false;
        } else {
            flgText.birth_at = '';
            errors.birth_at = true;
        }
    } else {
        flgText.birth_at = '생년월일을 정확히 입력해주세요.';
        errorStyle.birth_at = 'error-message';
        errors.birth_at = false;
    }
}

// 비밀번호 확인 체크
function passwordChkBlur(chkPw) {
    console.log(chkPw)
    if(formData.u_password == chkPw) {
        flgText.password_chk = '비밀번호와 일치합니다.';
        errorStyle.password_chk = 'pass-message';
        errors.password_match = true;
    } else {
        flgText.password_chk = '비밀번호와 일치하지 않습니다.';
        errorStyle.password_chk = 'error-message';
        errors.password_match = false;
    }
}

// 아이디 정규표현식 체크
function idBlur(id) {
    const chkId = /^[a-zA-Z0-9]{6,20}$/u;
    console.log(id)
    if(chkId.test(id)) {
        flgText.u_id = '사용가능한 아이디 입니다.';
        errorStyle.u_id = 'pass-message';
        errors.u_id = true;
    } else {
        flgText.u_id = '아이디는 영어 대소문자와 숫자를 사용한 6~20글자로 만들어주세요.';
        errorStyle.u_id = 'error-message';
        errors.u_id = false;
    }
}

// 전화번호 정규표현식 체크
function phoneBlur(phone) {
    const chkPhone = /^(01[016789]{1})-?[0-9]{3,4}-?[0-9]{4}$/;
    console.log(phone)
    if(chkPhone.test(phone)) {
        flgText.u_phone_num = '';
        errors.u_phone = true;
    } else {
        flgText.u_phone_num = '전화번호 형식에 맞게 입력해주세요. (010-1234-5678)';
        errorStyle.u_phone_num = 'error-message';
        errors.u_phone = false;
    }
}

// 상세 주소 체크
function addressChkBlur(addressChk) {
    if(addressChk == null || detailAddress == null) {
        flgText.address = '상세주소를 입력해주세요.';
        errorStyle.address = 'error-message';
        errors.address = false;
    } else {
        errors.address = true;
    }
}

function kakaoPostcode() {
    new daum.Postcode({
        oncomplete: function(data) {
            var addr = ''; // 주소 변수
            var extraAddr = ''; // 참고항목 변수
            if (data.userSelectedType === 'R') {
                addr = data.roadAddress;
            } else {
                addr = data.jibunAddress;
            }
            if(data.userSelectedType === 'R'){
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraAddr += data.bname;
                }
                if(data.buildingName !== '' && data.apartment === 'Y'){
                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                if(extraAddr !== ''){
                    extraAddr = ' (' + extraAddr + ')';
                }
            }
            postcode.value = data.zonecode;
            address.value = addr;
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

// function validateForm() {
//     errors.value = {
//         u_name: formData.value.u_name === '',
//         birth_at: formData.value.birth_at === '',
//         u_id: formData.value.u_id === '',
//         u_password: formData.value.u_password === '',
//         password_match: formData.value.u_password !== formData.value.password_chk,
//         u_address: address.value === '',
//         u_phone: formData.value.u_phone_num === '',
//         u_nickname: formData.value.u_nickname === '',
//         gender: formData.value.gender === ''
//     };

//     const hasErrors = Object.values(errors.value).some(error => error);

//     if (!hasErrors) {
//         isModalVisible.value = true;
//     }
// }

// 모달창 컨트롤
const isModalVisible = ref(false);

function handleRegistModal() {
    if (Object.values(errors).some(value => value === false)) {
        if(formData.u_name == '') {
            flgText.u_name = '이름을 입력해주세요.';
            errorStyle.u_name = 'error-message';
        }
        if(formData.birth_at == '') {
            flgText.birth_at = '생년월일을 입력해주세요.';
            errorStyle.birth_at = 'error-message';
        }
        if(formData.u_id == '') {
            flgText.u_id = '아이디를 입력해주세요.';
            errorStyle.u_id = 'error-message';
        }
        if(formData.u_password == '') {
            flgText.u_password = '비밀번호를 입력해주세요.';
            errorStyle.u_password = 'error-message';
        }
        if(formData.password_chk == '') {
            flgText.password_chk = '비밀번호를 확인해주세요.';
            errorStyle.password_chk = 'error-message';
        }
        if(formData.u_phone_num == '') {
            flgText.u_phone_num = '전화번호를 입력해주세요.';
            errorStyle.u_phone_num = 'error-message';
        }
        if(formData.u_nickname == '') {
            flgText.u_nickname = '닉네임을 입력해주세요.';
            errorStyle.u_nickname = 'error-message';
        }
        if(formData.gender == '') {
            flgText.gender = '성별을 선택해주세요.';
            errorStyle.gender = 'error-message';
        }
        if(address.value == '' || detailAddress.value == '') {
            flgText.address = '주소를 입력해주세요';
            errorStyle.address = 'error-message';
        }
        // alert('회원 정보 입력란을 다시 확인해주세요.')
        store.commit('setModalMessage', '회원 정보 입력란을 다시 확인해주세요.');
    } else {
        isModalVisible.value = true;                                                                   
    }
}

function closeModal() {
    isModalVisible.value = false;
}

function submitRegistration() {
    store.dispatch('registration')
}

function chkModal() {
    // alert('닉네임과 아이디 중복 체크 후 회원가입이 가능합니다.')
    store.commit('setModalMessage', '닉네임과 아이디 중복 체크 후 회원가입이 가능합니다.');
}

</script>

<style scoped src="../../css/regist.css"></style>
