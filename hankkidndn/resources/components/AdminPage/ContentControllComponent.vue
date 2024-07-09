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
                <!-- <div>신규 문의 사항 :</div> -->
            </div>
            <div class="main_category">
                <button @click="activeTab = 'recipe'">레시피 게시판</button>
                <button @click="activeTab = 'board'">일반 게시판</button>
                <button @click="activeTab= 'comment'">댓글 신고</button>
                <!-- <button @click="activeTab= 'qna'">문의 사항</button> -->
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
                            <div>{{ item.recipe_board_id }}</div>
                            <div>{{ item.title }}</div>
                            <div>{{ item.u_nickname }}</div>
                            <div>{{ item.report_cnt }}</div>
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
                        <div class="report" v-for="(item, index) in boardReportData" :key="index">
                            <div>{{ item.board_id }}</div>
                            <div>{{ item.title }}</div>
                            <div>{{ item.u_nickname }}</div>
                            <div>{{ item.report_cnt }}</div>
                            <div>
                                <button @click="boardShowModal(item)" type="button">상세보기</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pagenation_box" v-if="activeTab === 'board'">
                        <div class="pagenation">
                            <button v-if="boardCurrentPage !== 1" class="number" @click="boardPageMove(boardCurrentPage - 1)">이전</button>
                            <div v-for="page_num in boardPageNumbers" :key="page_num">
                                <button :class="{ activePage: page_num === boardCurrentPage }" class="number" @click="boardPageMove(page_num)">{{ page_num }}</button>
                            </div>
                            <button v-if="boardCurrentPage < boardTotalPages" class="number" @click="boardPageMove(boardCurrentPage + 1)">다음</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 댓글 신고 -->
            <div class="main_content" v-if="activeTab === 'comment'">
                <div class="recipe_report_list_head">
                    <div>번호</div>
                    <div>제목</div>
                    <div>작성자</div>
                    <div>누적횟수</div>
                    <div></div>
                </div>
                <div class="recipe_report_list">
                    <div class="report_list">
                        <div class="report" v-for="(item, index) in commentReportData" :key="index">
                            <div>{{ item.comments_id }}</div>
                            <div>{{ truncateText(item.content, 5) }}</div>
                            <div>{{ item.u_nickname }}</div>
                            <div>{{ item.report_cnt }}</div>
                            <div>
                                <button @click="commentShowModal(item)" type="button">상세보기</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pagenation_box" v-if="activeTab === 'comment'">
                        <div class="pagenation">
                            <button v-if="commentCurrentPage !== 1" class="number" @click="commentPageMove(commentCurrentPage - 1)">이전</button>
                            <div v-for="page_num in commentPageNumbers" :key="page_num">
                                <button :class="{ activePage: page_num === commentCurrentPage }" class="number" @click="commentPageMove(page_num)">{{ page_num }}</button>
                            </div>
                            <button v-if="commentCurrentPage < commentTotalPages" class="number" @click="commentPageMove(commentCurrentPage + 1)">다음</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 문의 사항 -->

        </div>
    </div>

    <!-- 레시피 신고 상세보기 모달 -->
    <div v-show="isModalVisible" class="detail_modal_container">
        <div class="modal_content">
            <div>
                <h2>신고 상세보기</h2>
            </div>
            <form id="recipeApproveForm">
              <div>
                <select name="approve_date">
                  <option value="1">3일정지</option>
                  <option value="2">7일정지</option>
                  <option value="3">30일정지</option>
                  <option value="4">영구정지</option>
                </select>
                <br>
                <textarea type="text" name="content" autocomplete="off"></textarea>
                <input type="hidden" v-if="$store.state.recipeReportList.length > 0" :value="$store.state.recipeReportList[0].recipe_board_id" name="recipe_board_id">
                <input type="hidden" v-if="$store.state.recipeReportList.length > 0" :value="$store.state.recipeReportList[0].id" name="user_id">
              </div>
              <div class="approve-container">
                <button @click="closeModal(); $store.dispatch('recipeReportApprove')" type="button">승인</button>
                <button @click="closeModal(); $store.dispatch('recipeReportReject', $store.state.recipeReportList[0].recipe_board_id)" type="button">비승인</button>
              </div>
            </form>
            <div>
              <div>해당 유저 제재 기록</div>
              <div v-if="$store.state.approveUserInfo != ''">
                <div class="approve-container">
                  <div>유저 닉네임</div>
                  <div>제재 사유</div>
                  <div>제재 기간</div>
                  <div>정지 종료 날짜</div>
                </div>
                <div class="approve-container" v-for="(item, index) in $store.state.approveUserInfo" :key="index">
                  <div>{{ item.u_nickname }}</div>
                  <div>{{ item.content }}</div>
                  <div>{{ item.period }}</div>
                  <div>{{ item.end_date }}</div>
                </div>
              </div>
              <div v-else>해당 유저는 제재 기록이 없습니다.</div>
            </div>
            <div class="modal_head" v-for="(item, index) in $store.state.recipeReportList" :key="index">
                <p>제목: {{ item.title }}</p>
                <p>작성자: {{ item.u_nickname }}</p>
                <p>신고자: {{ item.report_user_nickname }}</p>
                <p>신고사유: {{ item.content }}</p>
            </div>
            <button type="button" @click="closeModal">닫기</button>
        </div>
    </div>

    <!-- 게시판 신고 상세보기 모달 -->
    <div v-if="boardModalVisible" class="detail_modal_container">
        <div class="modal_content">
            <div>
                <h2>신고 상세보기</h2>
            </div>
            <form id="boardApproveForm">
              <div>
                <select name="approve_date">
                  <option value="1">3일정지</option>
                  <option value="2">7일정지</option>
                  <option value="3">30일정지</option>
                  <option value="4">영구정지</option>
                </select>
                <br>
                <textarea type="text" name="content" autocomplete="off"></textarea>
                <input type="hidden" :value="$store.state.boardReportList[0].board_id" name="board_id">
                <input type="hidden" :value="$store.state.boardReportList[0].id" name="user_id">
              </div>
              <div class="approve-container">
                <button @click="boardCloseModal(); $store.dispatch('boardReportApprove')" type="button">승인</button>
                <button @click="boardCloseModal(); $store.dispatch('boardReportReject', $store.state.boardReportList[0].board_id)" type="button">비승인</button>
              </div>
            </form>
            <div>
              <div>해당 유저 제재 기록</div>
              <div v-if="$store.state.approveUserInfo != ''">
                <div class="approve-container">
                  <div>유저 닉네임</div>
                  <div>제재 사유</div>
                  <div>제재 기간</div>
                  <div>정지 종료 날짜</div>
                </div>
                <div class="approve-container" v-for="(item, index) in $store.state.approveUserInfo" :key="index">
                  <div>{{ item.u_nickname }}</div>
                  <div>{{ item.content }}</div>
                  <div>{{ item.period }}</div>
                  <div>{{ item.end_date }}</div>
                </div>
              </div>
              <div v-else>해당 유저는 제재 기록이 없습니다.</div>
            </div>
            <div class="modal_head" v-for="(item, index) in $store.state.boardReportList" :key="index">
                <p>제목: {{ item.title }}</p>
                <p>작성자: {{ item.u_nickname }}</p>
                <p>신고자: {{ item.report_user_nickname }}</p>
                <p>신고사유: {{ item.content }}</p>
            </div>
            <button @click="boardCloseModal">닫기</button>
        </div>
    </div>

    <!-- 댓글 신고 상세보기 모달 -->
    <div v-if="commentModalVisible" class="detail_modal_container">
        <div class="modal_content">
            <div>
                <h2>신고 상세보기</h2>
            </div>
            <form id="commentApproveForm">
              <div>
                <select name="approve_date">
                  <option value="1">3일정지</option>
                  <option value="2">7일정지</option>
                  <option value="3">30일정지</option>
                  <option value="4">영구정지</option>
                </select>
                <br>
                <textarea type="text" name="content" autocomplete="off"></textarea>
                <input type="hidden" :value="$store.state.commentReportList[0].comment_id" name="comment_id">
                <input type="hidden" :value="$store.state.commentReportList[0].id" name="user_id">
              </div>
              <div class="approve-container">
                <button @click="commentCloseModal(); $store.dispatch('commentReportApprove')" type="button">승인</button>
                <button @click="commentCloseModal(); $store.dispatch('commentReportReject', $store.state.commentReportList[0].comments_id)" type="button">비승인</button>
              </div>
            </form>
            <div>
              <div>해당 유저 제재 기록</div>
              <div v-if="$store.state.approveUserInfo != ''">
                <div class="approve-container">
                  <div>유저 닉네임</div>
                  <div>제재 사유</div>
                  <div>제재 기간</div>
                  <div>정지 종료 날짜</div>
                </div>
                <div class="approve-container" v-for="(item, index) in $store.state.approveUserInfo" :key="index">
                  <div>{{ item.u_nickname }}</div>
                  <div>{{ item.content }}</div>
                  <div>{{ item.period }}</div>
                  <div>{{ item.end_date }}</div>
                </div>
              </div>
              <div v-else>해당 유저는 제재 기록이 없습니다.</div>
            </div>
            <div class="modal_head" v-for="(item, index) in $store.state.commentReportList" :key="index">
                <p>내용: {{ item.content }}</p>
                <p>작성자: {{ item.u_nickname }}</p>
                <p>신고자: {{ item.report_user_nickname }}</p>
                <p>신고사유: {{ item.content }}</p>
              </div>
            <button @click="commentCloseModal">닫기</button>
        </div>
    </div>
</template>

<script setup>
import { ref, onBeforeMount, computed, watch } from 'vue';
import { useStore } from 'vuex';
import { useRoute, useRouter } from 'vue-router';

const store = useStore();
const route = useRoute();
const router = useRouter();
const activeTab = ref('recipe');

// 레시피모달
const isModalVisible = ref(false);

const showModal = async (item) => {
  await store.dispatch('getApproveUserInfo', item.id);
  await store.dispatch('getRecipeReport', item.recipe_board_id)
  isModalVisible.value = true;
};
const closeModal = () => {
  isModalVisible.value = false;
};

// 게시판모달
const boardModalVisible = ref(false);

const boardShowModal = (item) => {
  store.dispatch('getApproveUserInfo', item.id);
  store.dispatch('getBoardReport', item.board_id)
  boardModalVisible.value = true;
};
const boardCloseModal = () => {
  boardModalVisible.value = false;
};

// 댓글 모달
const commentModalVisible = ref(false);

const commentShowModal = (item) => {
  store.dispatch('getApproveUserInfo', item.id);
  store.dispatch('getCommentReport', item.comments_id)
  commentModalVisible.value = true;
};
const commentCloseModal = () => {
  commentModalVisible.value = false;
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

// 게시판리폿리스트 페이지네이션
const boardReportData = computed(() => store.state.adminBoardReportList);
const adminBoardPagination = computed(() => store.state.adminBoardPagination);
const boardCurrentPage = computed(() => adminBoardPagination.value.current_page);
const boardTotalPages = computed(() => adminBoardPagination.value.last_page);

const boardPageNumbers = computed(() => {
  const boardStartPage = Math.floor((boardCurrentPage.value - 1) / 5) * 5 + 1;
  const boardEndPage = Math.min(boardStartPage + 4, boardTotalPages.value);
  const boardPages = [];
  for (let i = boardStartPage; i <= boardEndPage; i++) {
    boardPages.push(i);
  }
  return boardPages;
});
const boardPageMove = (page) => {
  if (page >= 1 && page <= boardTotalPages.value) {
    store.dispatch('getBoardReportList', page).then(() => {
      router.push({ query: { page } });
    });
  }
};

// 댓글리폿리스트 페이지네이션
const commentReportData = computed(() => store.state.adminCommentReportList);
const adminCommentPagination = computed(() => store.state.adminCommentPagination);
const commentCurrentPage = computed(() => adminCommentPagination.value.current_page);
const commentTotalPages = computed(() => adminCommentPagination.value.last_page);

const commentPageNumbers = computed(() => {
  const commentStartPage = Math.floor((commentCurrentPage.value - 1) / 5) * 5 + 1;
  const commentEndPage = Math.min(commentStartPage + 4, commentTotalPages.value);
  const commentPages = [];
  for (let i = commentStartPage; i <= commentEndPage; i++) {
    commentPages.push(i);
  }
  return commentPages;
});
const commentPageMove = (page) => {
  if (page >= 1 && page <= commentTotalPages.value) {
    store.dispatch('getCommentReportList', page).then(() => {
      router.push({ query: { page } });
    });
  }
};
// 가져오는 댓글이 너무 길 경우 자르기
const truncateText = (text, length) => {
  if (text.length <= length) {
    return text;
  }
  return text.slice(0, length) + '...';
};


// 워치
watch(() => route.query.page, (newPage) => {
  const pageNumber = parseInt(newPage) || 1;
  store.dispatch('getRecipeReportList', pageNumber);
  store.dispatch('getBoardReportList', pageNumber);
  store.dispatch('getCommentReportList', pageNumber);
});


// 온비포마운트
onBeforeMount(() => {
  const initialPage = route.query.page ? parseInt(route.query.page) : 1;
  store.dispatch('getRecipeReportList', initialPage);
  store.dispatch('getBoardReportList', initialPage);
  store.dispatch('getCommentReportList', initialPage);
  store.dispatch('getUsersReportInfo');
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
