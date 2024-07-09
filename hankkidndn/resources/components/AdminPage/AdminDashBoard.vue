<template>
    <div class="head_container">
        <div class="head_logo">
            <img class="img-logo" alt="logo" src="../../../public/img/logo.png">
        </div>
        <div class="head_title">한끼든든</div>
        <div></div>
        <div>
            <p>admin0001</p>    
        </div>
        <div>
            <button @click="$store.dispatch('adminLogout')" type="button">로그아웃</button>
        </div>
    </div>

    <div class="body_container">
        <div class="category">
            <button class="category_btn">대시보드</button>
            <button class="category_btn" @click="router.push('/adminnotice?page=1')">공지사항</button>
            <button class="category_btn">사용자 관리</button>
            <button class="category_btn">컨텐츠 관리</button>
            <button class="category_btn" @click="router.push('/adminad')"
            >광고, 캠페인 관리</button>
            <button class="category_btn">통계</button>
        </div>
        <div class="main_container">

            <div class="head_notice">
                <div>레시피 게시판 신고 : {{ $store.state.usersReportInfo.recipe_board_report_count }}</div>
                <div>게시판 신고 : {{ $store.state.usersReportInfo.board_report_count }}</div>
                <div>댓글 신고 : {{ $store.state.usersReportInfo.comment_report_count }}</div>
                
            </div>

            <!-- 신규 가입 추이 -->
            <div class="new_member_container">
                <div class="n_m_head">
                    <div>가입일</div>
                    <div>이름</div>
                    <div>닉네임</div>
                    <div>아이디</div>
                    <div>성별</div>
                    <div>생일</div>
                </div>
                <div class="n_m_body">
                    <div class="n_m_list">
                        <div>2024.07.08</div>
                        <div>노경호</div>
                        <div>경호쓰</div>
                        <div>simple0714</div>
                        <div>남자</div>
                        <div>1998.07.14</div>
                    </div>
                </div> 
            </div>
            
            <!-- 간략 통계 -->
            <div class="statistics">
                <div class="stats_head">
                    <div>일자</div>
                    <div>신규가입</div>
                    <div>새 레시피</div>
                    <div>새 게시글</div>
                    <div>탈퇴회원</div>
                </div>
                <div class="stats_body">
                    <div class="stats_list">
                        <div>2024.07.09</div>
                        <div>0</div>
                        <div>1</div>
                        <div>3</div>
                        <div>1</div>
                    </div>
                </div>
                <div class="stats_summary">
                    <div class="week_summary">
                        <div>최근 7일 합계</div>
                        <div>4</div>
                        <div>2</div>
                        <div>4</div>
                        <div>1</div>
                    </div>
                    <div class="month_summary">
                        <div>이번달(N) 합계</div>
                        <div>8</div>
                        <div>7</div>
                        <div>9</div>
                        <div>11</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
        
    
</template>

<script setup>


</script>

<style scoped src="../../css/admin_dash.css">

</style>