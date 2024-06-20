<template>
    <div class="container">
            <!-- 헤드 이미지 -->
            <img class="main-img" src="../../../public/img/my_page.png">
            <h2 class="page_title">마이페이지</h2>
            <div class="main_container">
                <div class="sub_title">
                    <div @click="$router.push('/mypage')" class="sub_title_content title_select">내 레시피</div>
                    <div @click="$router.push('/mypage/comments')" class="sub_title_content title_none_select">내 댓글</div>
                    <div @click="$router.push('/mypage/update')" class="sub_title_content title_none_select">개인정보수정</div>
                </div>
                <div class="main_content">
                <!-- 내 레시피 -->
                    <div class="main_my_page">
                        <!-- <img> -->
                        <img src="/img/otterface.png" alt="">
                        <h2>{{ $store.state.mypageUserinfo.u_nickname }} 님 안녕하세요.</h2>
                        <div class="main_comment">
                            <p>내가 쓴 글 {{ $store.state.mypageUserinfo.recipe_count }}건</p>
                            <p>내가 쓴 댓글 {{ $store.state.mypageUserinfo.comments_count }}건</p>
                        </div>
                    </div>
                    <div class="contents_box">
                        <div class="contents_head_box">
                            <button @click="activeTab = 'recipe'" class="title_select" :class="{ active: activeTab === 'recipe' }">
                                내가 쓴 레시피</button>
                            <button @click="activeTab = 'board'" class=" title_none_select" :class="{ active: activeTab === 'board'}">
                                내가 쓴 글</button>
                        </div>
                        <div class="contents_board_list">
                            
                            <div v-if="activeTab === 'recipe'">
                                <div class="my_list">
                                    <div class="list_title">제목</div>
                                    <div class="list_views">조회수</div>
                                    <div class="list_date">작성일</div>
                                </div>
                                <hr>
                                <div v-for="(item, index) in myRecipeData" :key="index">
                                    <div class="my_list">
                                        <div class="list_title">{{ item.title }}</div>
                                        <div class="list_views">{{ item.views }}</div>
                                        <div class="list_date">{{ formatDate(item.created_at) }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div v-if="activeTab === 'board'">
                                <div class="my_list">
                                    <div class="list_title">제목</div>
                                    <div class="list_views">조회수</div>
                                    <div class="list_date">작성일</div>
                                </div>
                                <hr>
                                <div  v-for="(item, index) in myBoardData" :key="index">
                                    <div class="my_list">
                                        <div class="list_title">{{ item.title }}</div>
                                        <div class="list_views">{{ item.views }}</div>
                                        <div class="list_date">{{ formatDate(item.created_at) }}</div>
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
import { onBeforeMount, ref, computed } from 'vue';
import { useStore } from 'vuex';

const store = useStore();
const activeTab = ref('recipe');
const myRecipeData = computed(() => store.state.mypageRecipeList);
const myBoardData = computed(() => store.state.mypageBoardList);

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('ko-KR', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    });
};
onBeforeMount(() => {
    store.dispatch('getMypageUserInfo');
    store.dispatch('getRecipeListInMy');
  store.dispatch('getBoardListInMy');
});

</script>
<style scoped src="../../css/my_recipe.css">
     @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>


