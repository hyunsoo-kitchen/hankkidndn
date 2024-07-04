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
            <button @click="$store.dispatch('adminLogout')" type="button" >로그아웃</button>
        </div>
    </div>

    <div class="body_container">
        <div class="category">
            <button class="category_btn">대시보드</button>
            <button class="category_btn">사용자 관리</button>
            <button class="category_btn">컨텐츠 관리</button>
            <button class="category_btn">광고, 캠페인 관리</button>
            <button class="category_btn">통계</button>
        </div>
        <div class="main_container">
            <div class="head_notice">
                <dvi>레시피 게시판 신고 :</dvi>
                <dvi>게시판 신고 :</dvi>
                <dvi>댓글 신고 :</dvi>
                <dvi>신규 문의 사항 :</dvi>
            </div>
            <div class="main_category">
                <button>레시피 게시판</button>
                <button>일반 게시판</button>
                <button>댓글 신고</button>
                <button>문의 사항</button>
            </div>

            <!-- 레시피 게시판 신고 -->
            <div class="main_content">
                <div class="recipe_report_list_head">
                    <div>번호</div>
                    <div>제목</div>
                    <div>작성자</div>
                    <div>누적횟수</div>
                    <div></div>
                </div>
                <div class="recipe_report_list">
                    <div class="report_list">
                        <div class="report">
                            <div>1</div>
                            <div>신고한 게시물</div>
                            <div>이현수달달달</div>
                            <div>3</div>
                            <div>
                                <button>상세보기</button>
                            </div>
                        </div>
                        <div class="report">
                            <div>1</div>
                            <div>신고한 게시물</div>
                            <div>이현수달달달</div>
                            <div>3</div>
                            <div>
                                <button>상세보기</button>
                            </div>
                        </div>
                        <div class="report">
                            <div>1</div>
                            <div>신고한 게시물</div>
                            <div>이현수달달달</div>
                            <div>3</div>
                            <div>
                                <button>상세보기</button>
                            </div>
                        </div>
                        <div class="report">
                            <div>1</div>
                            <div>신고한 게시물</div>
                            <div>이현수달달달</div>
                            <div>3</div>
                            <div>
                                <button>상세보기</button>
                            </div>
                        </div>
                        <div class="report">
                            <div>1</div>
                            <div>신고한 게시물</div>
                            <div>이현수달달달</div>
                            <div>3</div>
                            <div>
                                <button>상세보기</button>
                            </div>
                        </div>
                        <div class="report">
                            <div>1</div>
                            <div>신고한 게시물</div>
                            <div>이현수달달달</div>
                            <div>3</div>
                            <div>
                                <button>상세보기</button>
                            </div>
                        </div>
                        <div class="report">
                            <div>1</div>
                            <div>신고한 게시물</div>
                            <div>이현수달달달</div>
                            <div>3</div>
                            <div>
                                <button>상세보기</button>
                            </div>
                        </div>
                        <div class="report">
                            <div>1</div>
                            <div>신고한 게시물</div>
                            <div>이현수달달달</div>
                            <div>3</div>
                            <div>
                                <button>상세보기</button>
                            </div>
                        </div>
                        <div class="report">
                            <div>1</div>
                            <div>신고한 게시물</div>
                            <div>이현수달달달</div>
                            <div>3</div>
                            <div>
                                <button>상세보기</button>
                            </div>
                        </div>
                        <div class="report">
                            <div>1</div>
                            <div>신고한 게시물</div>
                            <div>이현수달달달</div>
                            <div>3</div>
                            <div>
                                <button>상세보기</button>
                            </div>
                        </div>
                        <div class="pagenation_box">
                            <div class="pagenation">
                                <button><<</button>
                                <button>1</button>
                                <button>2</button>
                                <button>3</button>
                                <button>4</button>
                                <button>5</button>
                                <button>>></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>




<!-- 레시피 신고 상세보기 모달 -->

</template>

<script setup>

</script>

<style scoped src="../../css/admin_content.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>