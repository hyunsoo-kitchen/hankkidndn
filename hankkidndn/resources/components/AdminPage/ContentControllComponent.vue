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
            <button class="category_btn">공지사항</button>
            <button class="category_btn">사용자 관리</button>
            <button class="category_btn">컨텐츠 관리</button>
            <button class="category_btn">광고, 캠페인 관리</button>
            <button class="category_btn">통계</button>
        </div>
        <div class="main_container">
            <div class="head_notice">
                <div>레시피 게시판 신고 :</div>
                <div>게시판 신고 :</div>
                <div>댓글 신고 :</div>
                <div>신규 문의 사항 :</div>
            </div>
            <div class="main_category">
                <button @click="activeTab = 'recipe'">레시피 게시판</button>
                <button @click="activeTab = 'board'">일반 게시판</button>
                <button @click="activeTab= 'comment'">댓글 신고</button>
                <button @click="activeTab= 'qna'">문의 사항</button>
            </div>

            <!-- 레시피 게시판 신고 -->
            <div class="main_content" v-if="activeTab === 'recipe'">
                <div class="recipe_report_list_head">
                    <div>번호</div>
                    <div>제목</div>
                    <div>작성자</div>
                    <div>누적횟수</div>
                    <div></div>
                </div>
                <div class="recipe_report_list">
                    <div class="report_list">
                        <div class="report" v-for="(item, index) in reportData" :key="index">
                            <div>{{ ($store.state.adminRecipePagination.total - index) - (($store.state.adminRecipePagination.current_page - 1) * 10) }}</div>
                            <div>{{ item.recipe_title }}</div>
                            <div>{{ item.recipe_author }}</div>
                            <div>{{ item.report_count }}</div>
                            <div>
                                <button @click="showModal(item)" type="button">상세보기</button>
                            </div>
                        </div>
                    </div>
                    
                    <div v-if="activeTab === 'recipe'" class="pagenation_box">
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

            <!-- 일반 게시판 신고 -->
            <div class="main_content" v-if="activeTab === 'board'">
                <div class="recipe_report_list_head">
                    <div>번호</div>
                    <div>제목</div>
                    <div>작성자</div>
                    <div>누적횟수</div>
                    <div></div>
                </div>
                <div class="recipe_report_list">
                    <div class="report_list">
                        <div class="report" v-for="(item, index) in reportData" :key="index">
                            <div>{{ ($store.state.adminRecipePagination.total - index) - (($store.state.adminRecipePagination.current_page - 1) * 10) }}</div>
                            <div>{{ item.recipe_title }}</div>
                            <div>{{ item.recipe_author }}</div>
                            <div>{{ item.report_count }}</div>
                            <div>test</div>
                            <div>
                                <button @click="showModal(item)" type="button">상세보기</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pagenation_box" v-if="activeTab === 'board'">
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
            <!-- 댓글 신고 -->

            <!-- 문의 사항 -->

        </div>
    </div>

    <!-- 레시피 신고 상세보기 모달 -->
    <div v-if="isModalVisible" class="detail_modal_container">
        <div class="modal_content">
            <div>
              <h2>신고 상세보기</h2>
            </div>
            <div class="modal_head">
              <p>제목: {{ selectedReport.recipe_title }}</p>
              <p>작성자: {{ selectedReport.recipe_author }}</p>
            </div>
            <div class="modal_body">
              <p>신고자: {{ selectedReport.reporter_nickname }}</p>
            </div>
            <div>
              <p>신고사유: {{ selectedReport.report_reason }}</p>
            </div>
            <div>
              <button @click="closeModal">닫기</button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onBeforeMount, computed, watch } from 'vue';
import { useStore } from 'vuex';
import { useRoute, useRouter } from 'vue-router';

const store = useStore();
const route = useRoute();
const router = useRouter();
const isModalVisible = ref(false);
const selectedReport = ref({});
const activeTab = ref('recipe');

//모달
const showModal = (item) => {
  selectedReport.value = item;
  isModalVisible.value = true;
};
const closeModal = () => {
  isModalVisible.value = false;
};

// 레시피리폿리스트 페이지네이션
const reportData = computed(() => store.state.adminRecipeReportList);
const adminRecipePagination = computed(() => store.state.adminRecipePagination);
const currentPage = computed(() => adminRecipePagination.value.current_page);
const totalPages = computed(() => adminRecipePagination.value.last_page);

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
    store.dispatch('getRecipeReportList', page).then(() => {
      router.push({ query: { page } });
    });
  }
};

// 워치
watch(() => route.query.page, (newPage) => {
  const pageNumber = parseInt(newPage) || 1;
  store.dispatch('getRecipeReportList', pageNumber);
});


// 온비포마운트
onBeforeMount(() => {
  const initialPage = route.query.page ? parseInt(route.query.page) : 1;
  store.dispatch('getRecipeReportList', initialPage);
});


</script>

<style scoped src="../../css/admin_content.css">
@import url('https://fonts.googleapis.com/css2?family=Jua&display=swap');

.activePage {
  font-weight: bold;
  background-color: #000;
  color: #fff;
}

.page_btn {
  margin: 0 2px;
  padding: 5px 10px;
  cursor: pointer;
}

.page_btn:disabled {
  cursor: not-allowed;
}
</style>
