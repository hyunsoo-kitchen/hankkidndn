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
            <button class="category_btn" @click="$router.push('/admindashboard')">대시보드</button>
            <button class="category_btn" @click="$router.push('/adminnotice?page=1')">공지사항</button>
            <button class="category_btn" @click="$router.push('/adminuserfind')">사용자 관리</button>
            <button class="category_btn" @click="$router.push('/admincontentcontroll')">신고 관리</button>
            <button class="category_btn" @click="$router.push('/adminad')">광고 관리</button>
            <button class="category_btn" @click="$router.push('/adminevent?page=1')">이벤트 관리</button>
        </div>
        <div class="main_container">

            <div class="head_notice">
                <div class="head_report_count">
                    <div>처리해야할 신고 수 : {{ approveChkCountData }}</div>
                </div>
                <div>
                    <h3></h3>
                </div>
                <div class="head_info">
                    <div>신규 가입자 : {{ todayStats.user_count }}</div> 
                    <div>탈퇴회원 : {{ todayStats.withdrawal_count }}</div>
                    <div>새 레시피 : {{ todayStats.recipe_count }}</div>
                    <div>새 게시글 : {{ todayStats.post_count }}</div>
                </div>
            </div>

            <!-- 신규 가입 추이 -->
            <div class="new_member_container">
                <div>
                    <h3>유저 조회</h3>
                    <hr>
                </div>
                <div class="n_m_head">
                    <div>가입일</div>
                    <div>이름</div>
                    <div>닉네임</div>
                    <div>아이디</div>
                    <div>성별</div>
                    <div>생일</div>
                </div>
                <hr>
                <div class="n_m_body">
                    <div class="n_m_list" v-for="(item, index) in AllUserData" :key="index">
                        <div>{{ item.created_at }}</div>
                        <div>{{ item.u_name }}</div>
                        <div>{{ item.u_nickname }}</div>
                        <div>{{ item.u_id }}</div>
                        <div>{{ item.gender === '0' ? '남자' : '여자' }}</div>
                        <div>{{ item.birth_at }}</div>
                    </div>
                    <div class="pagenation_box">
                        <div class="pagenation">
                            <button v-if="currentPage !== 1" class="number" @click="pageMove(currentPage - 1)">이전</button>
                            <div v-for="page_num in pageNumbers" :key="page_num">
                                <button :class="{ activePage: page_num === currentPage }" class="number" @click="pageMove(page_num)">{{ page_num }}</button>
                            </div>
                            <button v-if="currentPage < totalPages" class="number" @click="pageMove(currentPage + 1)">다음</button>
                        </div>
                    </div>
                </div> 
            </div>

        </div>
    </div>
        
    
</template>

<script setup>
import { onBeforeMount, computed, ref, watch } from 'vue';
import { useStore } from 'vuex';
import { useRoute, useRouter } from 'vue-router';

const store = useStore();
const route = useRoute();
const router = useRouter();

onBeforeMount(() => {
    const initialPage = route.query.page ? parseInt(route.query.page) : 1;
    store.dispatch('getDailyStatsList');
    store.dispatch('getApproveChkCount');
    store.dispatch('getAllUsersList', initialPage);
});

const todayStats = computed(() => store.state.todayStats);
const approveChkCountData = computed(() => store.state.approvechkCountData);


const AllUserData = computed(() => store.state.adminPageUserPagination.data);
const adminPageUserPagination = computed(() => store.state.adminPageUserPagination);
const currentPage = computed(() => adminPageUserPagination.value.current_page);
const totalPages = computed(() => adminPageUserPagination.value.last_page);

const pageNumbers = computed(() => {
  const startPage = Math.floor((currentPage.value - 1) / 5) * 5 + 1;
  const endPage = Math.min(startPage + 4, totalPages.value);
  const pages = [];
  for (let i = startPage; i <= endPage; i++) {
    pages.push(i);
  }
  return pages;
});
const pageMove = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    store.dispatch('getAllUsersList', page).then(() => {
      router.push({ query: { page } });
    });
  }
};

// 워치
watch(() => route.query.page, (newPage) => {
  const pageNumber = parseInt(newPage) || 1;
  store.dispatch('getAllUsersList', pageNumber);
});







// 현재 달 계산
const getCurrentMonth = () => {
    const now = new Date();
    const month = now.toLocaleString('default', { month: 'short' }); // 예: 'Jul' 또는 'July'
    return `${month}`;
};

const currentMonth = ref(getCurrentMonth());

</script>

<style scoped src="../../css/admin_users.css">

</style>