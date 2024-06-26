<template>
<div class="container">
    <!-- 헤드 이미지 -->
    <img class="main-img" src="../../../public/img/my_page.png">
    <h2 class="page_title">마이페이지</h2>
    <div class="main_container">
        <div class="sub_title">
            <div @click="$router.push('/mypage')" class="sub_title_content title_none_select">내 레시피</div>
            <div @click="$router.push('/mypage/comments')" class="sub_title_content title_none_select">내 댓글</div>
            <div @click="$router.push('/mypage/update')" class="sub_title_content title_select">개인정보수정</div>
        </div>
        <div class="main_content">

            <!-- 내 정보 변경 전 본인인증 -->
            <div class="auth_box" v-if="!isAuthenticated">
                <div class="">
                    <div>비밀번호</div>
                    <input type="password" v-model="u_password">
                </div>
                <button @click="authenticate">인증</button>
            </div>

            <!-- 개인정보 수정 -->
            <div class="update_container" v-if="isAuthenticated">
                <div class="user_container">
                    <div class="profile_img_box">
                        <img :src="$store.state.mypageUserinfo.profile" alt="">
                    </div>
                    <div class="user_nickname">
                        <h2>{{ $store.state.mypageUserinfo.u_nickname }}</h2>
                    </div>
                    <div class="user_id">
                        <h3>{{ $store.state.mypageUserinfo.u_id }}</h3>
                    </div>
                </div>
                <!-- 내 프로필 -->
                <div class="contents_head_box">
                    <button @click="activeTab = 'myprofile'" :class="{active: activeTab === 'myprofile', 
                    title_select: activeTab === 'myprofile', title_none_select: activeTab !== 'myprofile' }, title_select">
                    내 프로필</button>
                    <button @click="activeTab = 'security'" :class="{active: activeTab === 'security', 
                    title_select: activeTab === 'security', title_none_select: activeTab !== 'security' }, title_select">
                    보안설정</button>
                </div>
                <div class="contents_container">
                    <div v-if="activeTab === 'myprofile'">
                        <div class="contents_title">내 프로필</div>
                        <hr>
                        <div class="myprofile_title" @click="profileOpenModal">프로필 등록</div>

                        <div class="myprofile_title" @click="nicknameOpenModal">닉네임 변경</div>
                            
                        <div class="myprofile_title" @click="phoneOpenModal">휴대폰 번호 수정</div>
                            
                        <div class="myprofile_title" @click="dateOpenModal">생년월일 수정</div>

                        <div class="myprofile_title" @click="addressOpenModal">주소 수정</div>
                        
                        <!-- 내 정보 수정 모달 -->
                        <!-- 프로필 -->
                        <div class="modal_overlay"  v-if="profileModalVisible" @click.self="profileCloseModal">
                            <div class="profile_modal">
                                <div>프로필 이미지 등록</div>
                                <form action="" id="updateProfileForm">
                                    <img :src="preview" class="preview-image">
                                    <div>
                                        <label for="profile">이미지 업로드</label>
                                        <input @change="setFile($event)" id="profile" type="file" name="profile" accept="image/*" >
                                    </div>
                                </form>
                                    <button @click="profileCloseModal" class="cancle_btn" type="button">취소</button>
                                    <button @click="$store.dispatch('updateProfile')" class="update_btn" type="button">업로드</button>
                            </div>
                        </div>

                        <!-- 닉네임 -->
                        <div class="modal_overlay"  v-if="nicknameModalVisible" @click.self="nicknameCloseModal">
                            <div class="nickname_modal">
                                <div>닉네임 변경</div>
                                <form action="" id="updateNicknameForm">
                                    <input type="text" autoComplete="off" id="u_nickname" name="u_nickname" v-model="formData.u_nickname">
                                    <button class="check" type="button">중복확인</button>
                                </form>
                                    <button @click="nicknameCloseModal" class="cancle_btn">취소</button>
                                    <button class="update_btn" @click="$store.dispatch('updateNickname')">수정</button>
                            </div>
                        </div>
                        
                        <!-- 휴대폰번호 -->
                        <div class="modal_overlay"  v-if="phoneModalVisible" @click.self="phoneCloseModal">
                            <div class="phone_modal">
                                <div>휴대폰 번호 수정</div>
                                <form action="" id="updatePhoneForm">
                                    <input type="text" v-model="formData.u_phone_num" placeholder="010-1234-1234" id="u_phone_num" name="u_phone_num" autoComplete="off">
                                </form>
                                    <button @click="phoneCloseModal" class="cancle_btn">취소</button>
                                    <button class="update_btn" @click="$store.dispatch('updatePhonenum')">수정</button>
                            </div>
                        </div>
                        <!-- 생년월일 -->
                        <div class="modal_overlay" v-if="dateModalVisible" @click.self="dateCloseModal">
                            <div class="birth_modal">
                                <div>생년월일</div>
                                    <form action="" id="updateBirthForm">
                                        <input type="date" name="birth_at" id="birth_at" laceholder="2000-01-01" @input="chkBirth" v-model="formData.birth_at">
                                    </form>
                                        <button @click="dateCloseModal" class="cancle_btn">취소</button>
                                        <button class="update_btn" @click="$store.dispatch('updateBirthat')">수정</button>
                            </div>
                        </div>
                        <!-- 주소 -->
                        <div class="modal_overlay" v-if="addressModalVisible" @click.self="addressCloseModal">
                            <div class="address_modal">
                                <div>내 주소 수정</div>
                                    <div>
                                        <form action="" id="updateBirthForm">
                                            <input type="text" id="u_post" name="u_post" readonly v-model="postcode" class="input1" placeholder="우편번호">
                                        <button type="button" class="address_btn" @click="kakaoPostcode" id="post_search">주소검색</button>
                                        <input type="text" name="u_address" id="u_address" class="input2" v-model="address" readonly @click="kakaoPostcode">
                                        <input type="text" class="input3" name="u_detail_address" id="u_detail_address" v-model="detailAddress" autoComplete="off">
                                        </form>
                                    </div>
                                        <button @click="addressCloseModal" class="cancle_btn">취소</button>
                                        <button class="update_btn" @click="$store.dispatch('updateAddress')">수정</button>
                            </div>
                        </div>
                    </div>


                    <div v-if="activeTab === 'security'">
                        <div class="contents_title">보안설정</div>
                        <hr>
                        <form action="" id="updatePasswordForm">
                            <div class="detail_container">
                                <div class="detail_title">비밀번호 변경</div>
                                    <div class="detail_box">
                                        <label for="u_password">비밀번호</label>
                                        <input type="password" id="u_password" name="u_password" autoComplete="off" v-model="formData.u_password">
                                    </div>
                                    <div class="detail_box">
                                        <div class="password_chk">비밀번호 확인</div>
                                        <input type="password" id="password_chk" name="password_chk" autoComplete="off" v-model="formData.password_chk">
                                    </div>
                                <button class="update_btn"  @click.prevent="$store.dispatch('updatePassword')">수정</button>
                            </div>
                        </form>
                    </div>
                </div>
                    
            </div>
        </div>
    </div>
</div>

</template>
<script setup>
import { ref, computed, onBeforeMount } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const activeTab = ref('myprofile');
const address = ref('');
const detailAddress = ref('');
const postcode = ref('');
const preview = ref('');

const formData = ref({
    profile: null,
    birth_at: '',
    u_password: '',
    password_chk: '',
    u_phone_num: '',
    u_nickname: '',
});

// 유저 정보 인증
const u_password = ref('');
const isAuthenticated = computed(() => store.state.isAuthenticated);

// 모달창 컨트롤
const profileModalVisible = ref(false);
const nicknameModalVisible = ref(false);
const phoneModalVisible = ref(false);
const dateModalVisible = ref(false);
const addressModalVisible = ref(false);
// 프로필사진
const profileOpenModal = () => {
    profileModalVisible.value = true;
};
const profileCloseModal = () => {
    profileModalVisible.value = false;
};
// 닉네임
const nicknameOpenModal= () => {
    nicknameModalVisible.value = true;
};
const nicknameCloseModal= () => {
    nicknameModalVisible.value = false;
};
// 휴대전화
const phoneOpenModal = () => {
    phoneModalVisible.value = true;
};
const phoneCloseModal = () => {
    phoneModalVisible.value = false;
};
// 생년월일
const dateOpenModal = () => {
    dateModalVisible.value = true;
};
const dateCloseModal = () => {
    dateModalVisible.value = false;
};
// 주소
const addressOpenModal = () => {
    addressModalVisible.value = true;
};
const addressCloseModal = () => {
    addressModalVisible.value = false;
};


// const profilePreview = ref(null);
// 유저 인증
const authenticate = () => {
  store.dispatch('authenticate', u_password.value);
};

onBeforeMount(() => {
    store.dispatch('getMypageUserInfo');
});

//프로필 이미지 셋파일
function setFile(e) {
    const file = e.target.files[0]; // 파일 객체를 직접 formData.profile에 할당

    preview.value = URL.createObjectURL(file);
    // preview.value = file;
}

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







</script>
<style scoped src="../../css/my_update.css">
     @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>