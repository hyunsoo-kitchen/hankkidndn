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
                        <input type="text" name="u_name" v-model="formData.u_name" autoComplete="off">
                        <div class="error-message" v-if="errors.u_name">이름을 입력해주세요.</div>
                    </div>
                </div>
                <!-- 생년월일 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">생년월일 <span>*</span></div>
                    </div>
                    <div class="content">
                        <input type="date" name="birth_at" v-model="formData.birth_at" @input="chkBirth">
                        <div class="error-message" v-if="errors.birth_at">생년월일을 입력해주세요.</div>
                    </div>
                </div>
                <!-- 아이디 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">아이디 <span>*</span></div>
                    </div>
                    <div class="content">
                        <input type="text" name="u_id" v-model="formData.u_id" autoComplete="off">
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
                        <input type="password" name="u_password" v-model="formData.u_password" autoComplete="off">
                        <div class="error-message" v-if="errors.u_password">비밀번호를 입력해주세요.</div>
                    </div>
                </div>
                <!-- 비밀번호 확인 -->
                <div class="title_content">
                    <div class="title">
                        <div class="title_main">비밀번호 확인 <span>*</span></div>
                    </div>
                    <div class="content">
                        <input type="password" name="password_chk" v-model="formData.password_chk" autoComplete="off">
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
                        <input type="text" name="u_nickname" v-model="formData.u_nickname" autoComplete="off">
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
                            <input type="radio" name="gender" id="male" value="0" v-model="formData.gender">
                        </div>
                        <div>
                            <label for="female">여자</label>
                            <input type="radio" name="gender" id="female" value="1" v-model="formData.gender">
                        </div>
                    </div>
                    <div class="error-message" v-if="errors.gender">성별을 선택해주세요.</div>
                </div>
            
                <div class="buttons">
                    <button class="cancel" type="button" @click="$router.back()">취소</button>
                    <button class="complete" type="submit" @click="handleRegistModal">가입하기</button>
                </div>
            </div>
        </form>
    </div>

<!-- 가입확인 모달 -->
<div v-if="isModalVisible" class="modal_overlay"  @click.self="closeModal">
    <div>정말로 가입하시겠습니까?</div>
    <div>
        <p>입력하신 정보로 정말 가입하시겠습니까?</p>
    </div>
    <button @click="closeModal">취소</button>
    <button @click="submitRegistration">가입하기</button>
</div>
</template>

<script setup>
import { ref } from 'vue';
import { useStore } from 'vuex';
import { useRouter } from 'vue-router';

const store = useStore();
const router = useRouter();

const address = ref('');
const detailAddress = ref('');
const postcode = ref('');

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

function validateForm() {
    errors.value = {
        u_name: formData.value.u_name === '',
        birth_at: formData.value.birth_at === '',
        u_id: formData.value.u_id === '',
        u_password: formData.value.u_password === '',
        password_match: formData.value.u_password !== formData.value.password_chk,
        u_address: address.value === '',
        u_phone: formData.value.u_phone_num === '',
        u_nickname: formData.value.u_nickname === '',
        gender: formData.value.gender === ''
    };

    const hasErrors = Object.values(errors.value).some(error => error);

    if (!hasErrors) {
        isModalVisible.value = true;
    }
}

// 모달창 컨트롤
const isModalVisible = ref(false);
function handleRegistModal() {
    isModalVisible.value = true;                                                                   
}
function closeModal() {
    isModalVisible.value = false;
}

function submitRegistration() {
    store.dispatch('registration')
        // .then(() => {
        //     router.push('/registrationcomplete');
        // })
        // .catch(error => {
        //     console.log('회원가입 실패:', error);
        // });
}

</script>

<style scoped src="../../css/regist.css"></style>
