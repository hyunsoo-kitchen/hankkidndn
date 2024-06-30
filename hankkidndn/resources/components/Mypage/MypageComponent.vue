<template>
<div class="container">
    <!-- 헤드 이미지 -->
    <!-- <img class="main-img" src="../../../public/img/my_page.png"> -->
    <h2 class="page_title">마이페이지</h2>
    <hr>
    <div class="main_container">
        <div class="sub_title">
            <div @click="$router.push('/mypage')" class="sub_title_content title_none_select">내 레시피</div>
            <div @click="$router.push('/mypage/comments')" class="sub_title_content title_none_select">내 댓글</div>
            <div @click="$router.push('/mypage/update')" class="sub_title_content title_select">개인정보</div>
        </div>
        <div class="main_content">

            <!-- 내 정보 변경 전 본인인증 -->
            <div class="auth_box" v-if="!isAuthenticated">
                <div class="auth_title">
                    개인정보 열람, 수정
                    <hr>
                </div>
                <div class="auth_box_content">
                    개인정보 열람, 수정시 본인인증이 필요합니다. <br>
                    로그인 중인 아이디의 비밀번호를 입력해주세요.
                </div>
                <div class="auth_password_box">
                    <div>
                        <label for="password">비밀번호 : </label>
                        <input type="password" v-model="u_password" id="password">
                        <button class="auth_btn" @click="authenticate">인증</button>
                    </div>
                </div>
            </div>

            <!-- 개인정보 수정 -->
            <div class="update_container" v-if="isAuthenticated">
                <div class="main_my_page">
                        <!-- <img> -->
                        <div class="profile_img_box">
                            <img :src="$store.state.mypageUserinfo.profile" alt="">
                        </div>
                        <h2>{{ $store.state.mypageUserinfo.u_nickname }} 님 안녕하세요.</h2>
                        <div class="main_comment">
                            <p>내가 쓴 레시피 {{ $store.state.mypageUserinfo.recipe_count }}건</p>
                            <p>내가 쓴 글 {{ $store.state.mypageUserinfo.boards_count }}건</p>
                            <p>내가 쓴 댓글 {{ $store.state.mypageUserinfo.comments_count }}건</p>
                        </div>
                    </div>



                <!-- <div class="user_container">
                    <div class="profile_img_box">
                        <img :src="$store.state.mypageUserinfo.profile" alt="">
                    </div>
                    <div class="user_nickname">
                        <h2>{{ $store.state.mypageUserinfo.u_nickname }}</h2>
                    </div>
                </div> -->


                <!-- 내 프로필 -->
                <div class="contents_head_box">
                    <button @click="activeTab = 'myprofile'" :class="{active: activeTab === 'myprofile', 
                    title_select: activeTab === 'myprofile', title_none_select: activeTab !== 'myprofile' }, title_select">
                    내 프로필</button>
                    <button @click="activeTab = 'security'" :class="{active: activeTab === 'security', 
                    title_select: activeTab === 'security', title_none_select: activeTab !== 'security' }, title_select">
                    개인정보 변경</button>
                </div>
                <div class="contents_container">
                    <div v-if="activeTab === 'myprofile'">
                        <div class="contents_title">내 프로필</div>
                        <hr>
                        <div class="myprofile_container">
                            <div>
                                <p>이름 : {{ $store.state.mypageUserinfo.u_name }}</p>
                            </div>
                            <div>
                                <p>아이디 : {{ $store.state.mypageUserinfo.u_id }}</p>
                            </div>
                            <div>
                                <p>닉네임 : {{ $store.state.mypageUserinfo.u_nickname }}</p>
                            </div>    
                        </div>

                    </div>


                    <div v-if="activeTab === 'security'">
                        <div class="contents_title">개인정보 변경</div>
                        <hr>
                        <div class="myprofile_title_box">
                            <div class="myprofile_title" @click="profileOpenModal">프로필 등록</div>
    
                            <div class="myprofile_title" @click="nicknameOpenModal">닉네임 변경</div>
    
                            <div class="myprofile_title" @click="passwordOpenModal">비밀번호 변경</div>
                                
                            <div class="myprofile_title" @click="phoneOpenModal">휴대폰 번호 수정</div>
                                
                            <div class="myprofile_title" @click="dateOpenModal">생년월일 수정</div>
    
                            <div class="myprofile_title" @click="addressOpenModal">주소 수정</div>
                        </div>

                        <!-- 내 정보 수정 모달 -->
                        <!-- 프로필 -->
                        <div class="modal" v-if="profileModalVisible" @click.self="profileCloseModal">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h3 class="modal-title">프로필 이미지 등록</h3>
                                <button @click="profileCloseModal" class="close">×</button>
                                </div>
                                <div class="modal-body">
                                <form id="profileForm">
                                    <img :src="preview" class="preview-image">
                                    <div>
                                    <label for="profile">이미지 업로드</label>
                                    <input @change="setFile($event)" id="profile" type="file" name="profile" accept="image/*" >
                                    </div>
                                </form>
                                </div>
                                <div class="modal-footer">
                                <button type="button" @click="profileCloseModal" class="btn btn-primary1">취소</button>
                                <button type="button" class="btn btn-primary" @click="showConProfileModal">수정</button>
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- 닉네임 -->
                        <div class="modal" v-if="nicknameModalVisible" @click.self="nicknameCloseModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title">닉네임변경</h3>
                                <button @click="nicknameCloseModal" class="close">×</button>
                            </div>
                            <div class="modal-body">
                                <form action="" id="updateNicknameForm">
                                <input type="text" autoComplete="off" id="u_nickname" name="u_nickname" v-model="formData.u_nickname">
                                <button class="check" type="button">중복확인</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button @click="nicknameCloseModal" class="btn btn-primary1">취소</button>
                                <button class="btn btn-primary" @click="showConfirmationModal">수정</button>
                            </div>
                            </div>
                        </div>
                        </div>
                        <!-- 휴대폰 번호 수정 -->
                        <div class="modal" v-if="phoneModalVisible" @click.self="phoneCloseModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">휴대폰 번호 수정</h3>
                                    <button @click="phoneCloseModal" class="close">×</button>
                                </div>
                                <div class="modal-body">
                                    <form action="" id="updatePhoneForm">
                                        <input type="text" v-model="formData.u_phone_num" placeholder="010-1234-1234" id="u_phone_num" name="u_phone_num" autoComplete="off">
                                    <button class="check" type="button">중복확인</button>
                                </form>
                                </div>
                                <div class="modal-footer">
                                    <button @click="phoneCloseModal" class="btn btn-primary1">취소</button>
                                    <button class="btn btn-primary" @click="showConPhoneModal">수정</button>
                                </div>
                                </div>
                            </div>
                            </div>

                        <!-- 생년월일 -->
                        <div class="modal" v-if="dateModalVisible" @click.self="dateCloseModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">생년월일 수정</h3>
                                    <button @click="dateCloseModal" class="close">×</button>
                                </div>
                                <div class="modal-body">
                                    <form action="" id="updatePhoneForm">
                                        <input type="date" name="birth_at" id="birth_at" laceholder="2000-01-01" @input="chkBirth" v-model="formData.birth_at">
                                </form>
                                </div>
                                <div class="modal-footer">
                                    <button @click="dateCloseModal" class="btn btn-primary1">취소</button>
                                    <button class="btn btn-primary" @click="showConDateModal">수정</button>
                                </div>
                                </div>
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
                                        <button @click="addressCloseModal" class="btn btn-primary1">취소</button>
                                        <button class="btn btn-primary" @click="showConAddressModal">수정</button>
                            </div>
                        </div>
                        <!-- 비밀번호 -->
                        <div class="modal_overlay" v-if="passwordModalVisible" @click.self="passwordCloseModal">
                            <div class="address_modal">
                                <div>내 비밀번호 수정</div>
                                    <div>
                                        <form action="" id="updatePasswordForm">
                                            <div class="detail_box">
                                            <label for="u_password">비밀번호</label>
                                            <input type="password" id="u_password" name="u_password" autoComplete="off" v-model="formData.u_password">
                                            </div>
                                            <div class="detail_box">
                                                <div class="password_chk">비밀번호 확인</div>
                                                <input type="password" id="password_chk" name="password_chk" autoComplete="off" v-model="formData.password_chk">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="btn_box">
                                        <button @click="passwordCloseModal" class="btn btn-primary1">취소</button>
                                        <button class="btn btn-primary" @click="showConPasswordModal">수정</button>
                                    </div>
                            </div>
                        </div>

                        <!-- 개인정보 업데이트 모달모음 -->
                         <!-- 수정재확인 모달<프로필사진> -->
                        <div class="modal" v-if="conProfileModalVisivle" @click.self="closeConProfileModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">확인</h3>
                                    <button @click="closeConProfileModal" class="close">×</button>
                                </div>
                                <div class="modal-body">
                                    <p>정말 등록하시겠습니까?</p>
                                </div>
                                <div class="modal-footer">
                                    <button @click="closeConProfileModal" class="btn btn-primary1">취소</button>
                                    <button class="btn btn-primary" @click="updateProfile">확인</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- 수정재확인 모달<닉네임> -->
                        <div class="modal" v-if="confirmationModalVisible" @click.self="closeConfirmationModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">확인</h3>
                                    <button @click="closeConfirmationModal" class="close">×</button>
                                </div>
                                <div class="modal-body">
                                    <p>정말 수정하시겠습니까?</p>
                                </div>
                                <div class="modal-footer">
                                    <button @click="closeConfirmationModal" class="btn btn-primary1">취소</button>
                                    <button class="btn btn-primary" @click="confirmUpdateNickname">확인</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- 수정재확인 모달<비밀번호> -->
                        <div class="modal" v-if="conPasswodModalVisible" @click.self="closeConPasswordModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">확인</h3>
                                    <button @click="closeConPasswordModal" class="close">×</button>
                                </div>
                                <div class="modal-body">
                                    <p>정말 수정하시겠습니까?</p>
                                </div>
                                <div class="modal-footer">
                                    <button @click="closeConPasswordModal" class="btn btn-primary1">취소</button>
                                    <button class="btn btn-primary" @click="confirmUpdatePassword">확인</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- 수정재확인 모달<휴대폰번호> -->
                        <div class="modal" v-if="conPhoneModalVisible" @click.self="closeConPhoneModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">확인</h3>
                                    <button @click="closeConPhoneModal" class="close">×</button>
                                </div>
                                <div class="modal-body">
                                    <p>정말 수정하시겠습니까?</p>
                                </div>
                                <div class="modal-footer">
                                    <button @click="closeConPhoneModal" class="btn btn-primary1">취소</button>
                                    <button class="btn btn-primary" @click="confirmUpdatePhone">확인</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- 수정재확인 모달<생년월일> -->
                        <div class="modal" v-if="conDateModalVisible" @click.self="closeConDateModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">확인</h3>
                                    <button @click="closeConDateModal" class="close">×</button>
                                </div>
                                <div class="modal-body">
                                    <p>정말 수정하시겠습니까?</p>
                                </div>
                                <div class="modal-footer">
                                    <button @click="closeConDateModal" class="btn btn-primary1">취소</button>
                                    <button class="btn btn-primary" @click="confirmUpdateDate">확인</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- 수정재확인 모달<주소> -->
                        <div class="modal" v-if="conAddressModalVisible" @click.self="closeConDateModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">확인</h3>
                                    <button @click="closeConDateModal" class="close">×</button>
                                </div>
                                <div class="modal-body">
                                    <p>정말 수정하시겠습니까?</p>
                                </div>
                                <div class="modal-footer">
                                    <button @click="closeConDateModal" class="btn btn-primary1">취소</button>
                                    <button class="btn btn-primary" @click="confirmUpdateAddress">확인</button>
                                </div>
                                </div>
                            </div>
                        </div>



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

// 유저 인증
const authenticate = () => {
  store.dispatch('authenticate', u_password.value);
};

onBeforeMount(() => {
    store.dispatch('getMypageUserInfo');
});

// 유저 정보 인증
const u_password = ref('');
const isAuthenticated = computed(() => store.state.isAuthenticated);

// 모달창 컨트롤
const selectedFile = ref(null);
//--------------------------------------------------------------------------------
// 프로필 업데이트 //
const profileModalVisible = ref(false);
const conProfileModalVisivle = ref(false);

const profileOpenModal = () => {
    profileModalVisible.value = true;
};
function profileCloseModal() {
    profileModalVisible.value = false;
    preview.value = null;
    selectedFile.value = null;
};
const showConProfileModal = () => {
    conProfileModalVisivle.value = true;
}
const closeConProfileModal = () => {
    conProfileModalVisivle.value = false;
}

function updateProfile() {
  if (selectedFile.value) {
    store.dispatch('updateProfile').then(() => {
        profileCloseModal();
        closeConProfileModal();  
    });
  }
}




function setFile(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = (e) => {
      const img = new Image();
      img.src = e.target.result;
      img.onload = () => {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 150;
        canvas.height = 150;
        const size = Math.min(img.width, img.height);
        const dx = (img.width - size) / 2;
        const dy = (img.height - size) / 2;
        ctx.beginPath();
        ctx.arc(75, 75, 75, 0, Math.PI * 2);
        ctx.clip();
        ctx.drawImage(img, dx, dy, size, size, 0, 0, 150, 150);
        preview.value = canvas.toDataURL('image/png');
        selectedFile.value = file;
      };
    };
    reader.readAsDataURL(file);
  }
}

// 프로필 끝 //
//--------------------------------------------------------------------------------
// 닉네임 업데이트 //
const nicknameModalVisible = ref(false);
const confirmationModalVisible = ref(false);
const nicknameOpenModal= () => {
    nicknameModalVisible.value = true;
};
const nicknameCloseModal= () => {
    nicknameModalVisible.value = false;
};
const showConfirmationModal = () => {
    confirmationModalVisible.value = true;
};
const closeConfirmationModal = () => {
    confirmationModalVisible.value = false;
};
const confirmUpdateNickname = () => {
  store.dispatch('updateNickname', formData.value.u_nickname)
    .then(() => {
      nicknameCloseModal();
      closeConfirmationModal();
    });
};
// 닉네임 업데이트 끝 //
//----------------------------------------------------------------------------------
// 비밀번호 업데이트 //
const passwordModalVisible = ref(false);
const conPasswodModalVisible = ref(false);
const passwordOpenModal = () => {
    passwordModalVisible.value = true;
};
const passwordCloseModal = () => {
    passwordModalVisible.value = false;
};
const showConPasswordModal = () => {
    conPasswodModalVisible.value = true;
};
const closeConPasswordModal = () => {
    conPasswodModalVisible.value = false;
};
const confirmUpdatePassword = () => {
  store.dispatch('updatePassword', formData.value.u_password)
    .then(() => {
        passwordCloseModal();
        closeConPasswordModal();
    });
};
// 비밀번호 끝 //
//----------------------------------------------------------------------------------
// 휴대폰번호 시작//
const phoneModalVisible = ref(false);
const conPhoneModalVisible = ref(false);
const phoneOpenModal = () => {
    phoneModalVisible.value = true;
};
const phoneCloseModal = () => {
    phoneModalVisible.value = false;
};
const showConPhoneModal = () => {
    conPhoneModalVisible.value = true;
}
const closeConPhoneModal = () => {
    conPhoneModalVisible.value = false;
}
const confirmUpdatePhone = () => {
  store.dispatch('updatePhonenum', formData.value.u_phone_num)
    .then(() => {
        phoneCloseModal();
        closeConPhoneModal();
    });
};
// 휴대폰번호 끝
//----------------------------------------------------------------------------------
// 생년월일 시작
const dateModalVisible = ref(false);
const conDateModalVisible = ref(false);
const dateOpenModal = () => {
    dateModalVisible.value = true;
};
const dateCloseModal = () => {
    dateModalVisible.value = false;
};
const showConDateModal = () => {
    conDateModalVisible.value = true;
}
const closeConDateModal = () => {
    conDateModalVisible.value = false;
}
const confirmUpdateDate = () => {
  store.dispatch('updateBirthat', formData.value.birth_at)
    .then(() => {
        dateCloseModal();
        closeConDateModal();
    });
};
// 생년월일 끝
//----------------------------------------------------------------------------------
// 주소 업데이트 시작
const addressModalVisible = ref(false); 
const conAddressModalVisible = ref(false);
const addressOpenModal = () => {
    addressModalVisible.value = true;
};
const addressCloseModal = () => {
    addressModalVisible.value = false;
};
const showConAddressModal = () => {
    conAddressModalVisible.value = true;
}
const closeConAddressModal = () => {
    conAddressModalVisible.value = false;
}
const confirmUpdateAddress = () => {
  store.dispatch('updateAddress', formData.value.u_post, formData.value.u_address, formData.value.u_detail_address)
    .then(() => {
        addressCloseModal();
        closeConAddressModal();
    });
};





// 카카오 주소 API //
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