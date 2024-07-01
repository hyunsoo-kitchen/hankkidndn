<template>
    <div class="container">
            <!-- 헤드 이미지 -->
            <!-- <img class="main-img" src="../../../public/img/my_page.png"> -->
            <h2 class="page_title">마이페이지</h2>
            <hr>
            <div class="main_container">
                <div class="sub_title">
                    <div @click="$router.push('/mypage')" class="sub_title_content title_select cursor">내 레시피</div>
                    <div @click="$router.push('/mypage/comments')" class="sub_title_content title_none_select cursor">내 댓글</div>
                    <div @click="$router.push('/mypage/update')" class="sub_title_content title_none_select cursor">개인정보</div>
                </div>
                <div class="main_content">
                <!-- 내 레시피 -->
                    <div class="main_my_page">
                        <!-- <img> -->
                        <div class="profile_img_box">
                            <img :src="$store.state.mypageUserinfo.profile" alt="">
                        </div>
                        <h2>{{ $store.state.mypageUserinfo.u_nickname }} 님 안녕하세요.</h2>
                        <div class="main_comment">
                            <p>내가 쓴 레시피 : {{ $store.state.mypageUserinfo.recipe_count }}건</p>
                            <p>내가 쓴 글 : {{ $store.state.mypageUserinfo.boards_count }}건</p>
                            <p>내가 쓴 댓글 : {{ $store.state.mypageUserinfo.comments_count }}건</p>
                        </div>
                    </div>
                    <div class="contents_box">
                        <div class="contents_head_box">
                            <button @click="activeTab = 'recipe'"  :class="{ active: activeTab === 'recipe', title_select: activeTab === 'recipe', title_none_select: activeTab !== 'recipe' }, title_select">
                                내가 쓴 레시피</button>
                            <button @click="activeTab = 'board'"  :class="{ active: activeTab === 'board', title_select: activeTab === 'board', title_none_select: activeTab !== 'board'}, title_select">
                                내가 쓴 글</button>
                        </div>
                        <div class="contents_list">
                            <div v-if="activeTab === 'recipe'">
                                <div class="head_list">
                                    <div class="list_num">번호</div>
                                    <div class="list_title">제목</div>
                                    <div class="list_views">조회수</div>
                                    <div class="list_date">작성일</div>
                                </div>
                                <hr>
                                <div v-for="(item, index) in myRecipeData" :key="index">
                                    <div class="my_list">
                                        <div class="list_num">{{ ($store.state.myRecipePagination.total - index) - (($store.state.myRecipePagination.current_page - 1) * 10) }}</div>
                                        <div class="list_title" @click="$store.dispatch('getRecipeDetail', item.id)">{{ item.title }}</div>
                                        <div class="list_views">{{ item.views }}</div>
                                        <div class="list_date">{{ formatDate(item.created_at) }}</div>
                                    </div>
                                </div>
                                <!-- 레시피 페이지네이션 -->
                                <div v-if="activeTab === 'recipe'" class="page_btn_box">
                                    <button class="page_btn" @click="RprevPage()" :disabled="RcurrentPage === 1">이전</button>
                                    <span>{{ RcurrentPage }} / {{ RtotalPages }}</span>
                                    <button class="page_btn" @click="RnextPage()" :disabled="RcurrentPage === RtotalPages">다음</button>
                                </div>
                            </div>
                            
                            <div v-if="activeTab === 'board'">
                                <div class="head_list">
                                    <div class="list_num">번호</div>
                                    <div class="list_title">제목</div>
                                    <div class="list_views">조회수</div>
                                    <div class="list_date">작성일</div>
                                </div>
                                <hr>
                                <div  v-for="(item, index) in myBoardData" :key="index">
                                    <div class="my_list">
                                        <div class="list_num">{{ ($store.state.myBoardPagination.total - index) - (($store.state.myBoardPagination.current_page - 1) * 10) }}</div>
                                        <div class="list_title" @click="$store.dispatch('getBoardDetail', item.id)">{{ item.title }}</div>
                                        <div class="list_views">{{ item.views }}</div>
                                        <div class="list_date">{{ formatDate(item.created_at) }}</div>
                                    </div>
                                </div>
                                <!-- 게시판 페이지네이션 -->
                                <div v-if="activeTab === 'board'" class="page_btn_box">
                                    <button class="page_btn" @click="BprevPage()" :disabled="BcurrentPage === 1">이전</button>
                                    <span>{{ BcurrentPage }} / {{ BtotalPages }}</span>
                                    <button class="page_btn" @click="BnextPage()" :disabled="BcurrentPage === BtotalPages">다음</button>
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

// 페이지 네이션
const myRecipePagination = computed(() => store.state.myRecipePagination);
const myBoardPagination = computed(() => store.state.myBoardPagination);

// 내가 쓴 레시피 현재 페이지와 총 페이지 수 계산
const RcurrentPage = computed(() => myRecipePagination.value.current_page || 1);
const RtotalPages = computed(() => myRecipePagination.value.last_page || 1);

// 내가 쓴 게시글 현재 페이지와 총 페이지 수 계산
const BcurrentPage = computed(() => myBoardPagination.value.current_page || 1);
const BtotalPages = computed(() => myBoardPagination.value.last_page || 1);

// 레시피 페이지네이션 처리
const RprevPage = () => {
  if (RcurrentPage.value > 1) {
    store.dispatch('getRecipeListInMy', RcurrentPage.value - 1);
  }
};
const RnextPage = () => {
  if (RcurrentPage.value < RtotalPages.value) {
    store.dispatch('getRecipeListInMy', RcurrentPage.value + 1);
  }
};
// 게시글 페이지 네이션
const BprevPage = () => {
  if (BcurrentPage.value > 1) {
    store.dispatch('getBoardListInMy', BcurrentPage.value - 1);
  }
};
const BnextPage = () => {
  if (BcurrentPage.value < BtotalPages.value) {
    store.dispatch('getBoardListInMy', BcurrentPage.value + 1);
  }
};



const formatDate = (dateString) => {
    return new Date(dateString).toLocaleDateString('ko-KR', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    }).replace(/\.$/, '');  // 마지막 점제거
};


onBeforeMount(() => {
    store.dispatch('getMypageUserInfo');
    store.dispatch('getBoardListInMy', 1);
    store.dispatch('getRecipeListInMy', 1);
    //새로고침시 무조건 리스트 1페이지로 이동 해결 TODO

    // 남겨두기
    // store.dispatch('getBoardListInMy', route.query.page); 
    // store.dispatch('getRecipeListInMy', route.query.page);
    // if(store.state.myBoardPagination.current_page == 1) {
    //         store.dispatch('getBoardListInMy', 1);
    //     }
    // if(store.state.myRecipePagination.current_page == 1) {
    //         store.dispatch('getRecipeListInMy', 1);
        // }
});

</script>
<style scoped src="../../css/my_recipe.css">
     @import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');
</style>


