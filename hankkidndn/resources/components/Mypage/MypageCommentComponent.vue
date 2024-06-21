<template>
    <div class="container">
            <!-- 헤드 이미지 -->
            <img class="main-img" src="../../../public/img/my_page.png">
            <h2 class="page_title">마이페이지</h2>
            <div class="main_container">
                <div class="sub_title">
                    <div @click="$router.push('/mypage')" class="sub_title_content title_none_select">내 레시피</div>
                    <div @click="$router.push('/mypage/comments')" class="sub_title_content title_select">내 댓글</div>
                    <div @click="$router.push('/mypage/update')" class="sub_title_content title_none_select">개인정보수정</div>
                </div>
                <div class="main_content">
                    <!-- 내 레시피 -->
                    <div class="main_my_page">
                        <img :src="$store.state.mypageUserinfo.profile">
                        <h2>{{ $store.state.mypageUserinfo.u_nickname }} 님 안녕하세요.</h2>
                        <div class="main_comment">
                            <p>내가 쓴 레시피 {{ $store.state.mypageUserinfo.recipe_count }}건</p>
                            <p>내가 쓴 글 {{ $store.state.mypageUserinfo.recipe_count }}건</p>
                            <p>내가 쓴 댓글 {{ $store.state.mypageUserinfo.comments_count }}건</p>
                        </div>
                    </div>
                    <div class="contents_box">
                        <div class="contents_head_box">
                            <button @click="activeTab = 'recipe'"  :class="{ active: activeTab === 'recipe', title_select: activeTab === 'recipe', title_none_select: activeTab !== 'recipe' }, title_select">
                                내가 쓴 레시피 댓글</button>
                            <button @click="activeTab = 'board'"  :class="{ active: activeTab === 'board', title_select: activeTab === 'board', title_none_select: activeTab !== 'board'}, title_select">
                                내가 쓴 게시판 댓글</button>
                        </div>
                        <div class="contents_list">
                            <div v-if="activeTab === 'recipe'">
                                <div class="my_list">
                                    <div>번호</div>
                                    <div>제목</div>
                                    <div>조회수</div>
                                    <div>작성일</div>
                                </div>
                                <hr>
                                <div>
                                    <div class="my_list">
                                        <dvi></dvi>
                                        <dvi></dvi>
                                        <dvi></dvi>
                                        <dvi></dvi>
                                    </div>
                                </div>
                                <!-- 레시피 댓글 페이지네이션 -->
                                <div>
                                    <button class="page_btn">이전</button>
                                    <span> 1 / 2</span>
                                    <button class="page_btn">다음</button>
                                </div>
                            </div>
                        </div>

                        <div class="contents_list">
                            <div v-if="activeTab === 'board'">
                                <div class="my_list">
                                    <div>번호</div>
                                    <div>제목</div>
                                    <div>조회수</div>
                                    <div>작성일</div>
                                </div>
                                <hr>
                                <div>
                                    <div class="my_list">
                                        <dvi></dvi>
                                        <dvi></dvi>
                                        <dvi></dvi>
                                        <dvi></dvi>
                                    </div>
                                </div>
                                <!-- 레시피 댓글 페이지네이션 -->
                                <div>
                                    <button class="page_btn">이전</button>
                                    <span> 1 / 2</span>
                                    <button class="page_btn">다음</button>
                                </div>
                            </div>
                        </div>

                </div>
                </div>
            </div>
    </div>
</template>
<script setup>
import { onBeforeMount } from 'vue';
import { useStore } from 'vuex';

const store = useStore();

const activeTab = ref('recipe');


onBeforeMount(() => {
    store.dispatch('getMypageUserInfo');
});
</script>
<style scoped src="../../css/my_comment.css">
    @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>