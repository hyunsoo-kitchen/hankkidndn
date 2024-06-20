<template>
    <div class="container">
        <!-- 헤드 이미지 -->
        <img class="main-img" src="../../../public/img/my_page.png">
        <h2 class="page_title">마이페이지</h2>
        <div class="main_container">
            <div class="sub_title">
                <div class="sub_title_content title_none_select">내 레시피</div>
                <div class="sub_title_content title_none_select">내 댓글</div>
                <div class="sub_title_content title_select">개인정보수정</div>
            </div>
            <form class="main_content" id="myPageForm">
                <!-- 개인정보수정 -->
                <div class="main-box">
                    <div class="title">이름</div>
                    <div class="sub-title-main">
                        <input type="text" name="u_name" readonly :value="$store.state.userInfo.u_name">
                        <div></div>
                    </div>
                </div>
                <div class="main-box">
                    <div class="title">아이디</div>
                    <div class="sub-title-main">
                        <input type="text" name="u_id" readonly :value="$store.state.userInfo.u_id">
                        <!-- <input type="text" name="u_id" readonly value="tester123"> -->
                        <div></div>
                    </div>
                </div>
                <div class="main-box">
                    <div class="title">비밀번호</div>
                    <div class="sub-title-main">
                        <input name="u_password" type="password">
                        <button type="button" class="change">비밀번호변경</button>
                    </div>
                </div>
                <div class="main-box">
                    <div class="title">주소</div>
                    <div class="sub-title-street">
                        <!-- <input class="input3" type="text" name="u_post" readonly :value="$store.state.userInfo.u_post"> -->
                        <input class="input3" type="text" name="u_post" readonly>
                        <!-- <input class="input1" type="text" name="u_address" readonly :value="$store.state.userInfo.u_address"> -->
                        <input class="input1" type="text" name="u_address" readonly>
                        <!-- <input class="input2" type="text" name="u_detail_address" readonly :value="$store.state.userInfo.u_detail_address"> -->
                        <input class="input2" type="text" name="u_detail_address" readonly>
                    </div>
                </div>
                <div class="main-box">
                    <div class="title">휴대전화</div>
                    <div class="sub-title-number">
                        <div class="phone-number">
                            <!-- <select name="first_num" id="phone-num">
                                <option value="010" :selected="$store.state.userInfo.phone.split('-')[0] == '010'">010</option>
                                <option value="011" :selected="$store.state.userInfo.phone.split('-')[0] == '011'">011</option>
                                <option value="016" :selected="$store.state.userInfo.phone.split('-')[0] == '016'">016</option>
                                <option value="02" :selected="$store.state.userInfo.phone.split('-')[0] == '02'">02</option>
                                <option value="053" :selected="$store.state.userInfo.phone.split('-')[0] == '053'">053</option>
                            </select>
                            <input name="middle_num" class="phone" type="text" :value="$store.state.userInfo.phone.split('-')[1]">
                            <input name="last_num" class="phone" type="text" :value="$store.state.userInfo.phone.split('-')[2]">
                            <div></div> -->
                        </div>
                    </div>
                </div>
                <div class="main-box">
                    <div class="title">닉네임</div>
                    <div class="sub-title-main">
                        <!-- <input name="u_nickname" type="text" :value="$store.userInfo.u_nickname"> -->
                        <input name="u_nickname" type="text">
                        <button type="button" class="change">닉네임변경</button>
                    </div>
                </div>
                <div class="buttons">
                    <button type="button" @click="$router.back()" class="cancel">취소</button>
                    <button type="button" @click="$store.dispatch('userInfoUpdate')"class="complete">완료</button>
                </div>
            </form>
        </div>
    </div>
    </template>
    <script upset>
    
    </script>
    <style scoped src="../../css/my_update.css">
         @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
    </style>