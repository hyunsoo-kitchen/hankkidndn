<!-- 근데 이거 url이  -->
<!-- 127.0.0.1:8000/search/recipe?apge=1 -->
<!-- 이거든 -->
<!-- 일단 이것도 참고해서 해야지 -->
 <template>
    <div class="modal" v-show="insertModal">
     <div class="modal-dialog">
      <div class="modal-content">
       <div class="modal-header">
        <h3 class="modal-title">알림</h3>
        <button @click="insertModalOff" class="close">x</button>
       </div>
       <div class="modal-body">
        <p>글 작성은 로그인 후 가능합니다.</p>
       </div>
       <div class="modal-footer">
        <button @click="insertModalOff" class="btn btn-primary">확인</button>
       </div> 
      </div>
     </div>
    </div>
    <div class="container">
     <div class="header">
      <div class="main-img">
       <img src="img-main" src="../../../public/img/recipe.png">
      </div>
      <div class="input-btn">
        <div>
            <input v-model="data.search" class="search-input" type="text" placeholder="Search..">
        </div>
        <div>
         <button @click="search" class="search" type="button">
          <img src="../../../public/img/search.png">
         </button>
        </div>
      </div>
      <div class="ul-list">
        <ul>
            <li :class="{ 'active': $route.params.id == 100 }" @click="recipeTypeMove(100)" class="line">전체</li>
            <li :class="{ 'active': $route.params.id == 1 }" @click="recipeTypeMove(1)" class="line">한식</li>
            <li :class="{ 'active': $route.params.id == 2 }" @click="recipeTypeMove(2)" class="line">중식</li>
            <li :class="{ 'active': $route.params.id == 3 }" @click="recipeTypeMove(3)" class="line">양식</li>
            <li :class="{ 'active': $route.params.id == 4 }" @click="recipeTypeMove(4)" class="line">일식</li>
            <li :class="{ 'active': $route.params.id == 5 }" @click="recipeTypeMove(5)" class="line">베이커리</li>
        </ul>
      </div>
     </div>
     <div class="main-list">
      <div class="main-list-title">
        <h3>총 {{ $store.state.pagination.total }}개의 레시피가 있습니다.</h3>
        <button v-if="$store.state.authFlg" @click="$router.push('/recipe/insert')">레시피 작성하기</button>
        <button v-if="!$store.state.authFlg" @click="insertModalOn()">레시피 작성하기</button>
      </div>
      <div class="main-list-content">
        <div class="card" v-for="(item, index) in $store.state.recipeListData" :key="index">
         <img src="" @click="store.dispatch('getRecipeDetail', item.id)">
         <div class="card-title">{{ item.title }}</div>
         <div class="card-name">{{ item.u_nickname }}</div>
         <div class="star-view">
            <div class="card-star">{{ formData(item.created_at)}}</div>
            <div class="card-view">조회수 : {{ item.views }}</div>
         </div>
        </div>
      </div>
      <div class="btn-container">
        <button v-if="$store.state.pagination.current_page !== 1" class="number" @click="pageMove($store.state.pagination.current_page -1)">이전</button>
         <div v-for="page_num in page" :key="page_num">
          <button :class="{ activePage: page_num === $store.state.pagination.current_page}" class="number" @click="pageMove(page_num)">{{ page_num }}</button>
         </div>
          <button v-if="$store.state.pagination.current_page < $store.state.pagination.last_page" class="number" @click="pageMove($store.state.pagination.current_page + 1)">다음</button>
      </div>
     </div>
    </div>
 </template>
 <script setup>

 import { onBeforeMount, ref, watch } from 'vue';
 import { useStore } from 'vuex';
 import { useRoute } from 'vue-router';

 const store = useStore();
 const route = useRoute();
 const page = ref(route.query.page);
 const insertModal = ref(false);

 const data = {
    board_type: '',
    page: '',
    search: '',
 };

 watch(() => [route.query.page, route.params.id], ([newPage, newId]) => {
    data.page = newPage;
    data.board_type = newId
    pagination(newPage);
    store.dispatch('getRecipeList', data);
 });

 // pagination 함수 정의
 function pagination(nowPage) {
    // Vuex 스토어에서 마지막 페이지 수를 가져옴
    const last_page = store.state.pagination.last_page;
    // 현재 페이지를 기준으로 시작 페이지를 계산
    const start_page = (Math.ceil(nowPage / 5)) * 5 - 4;
    // 표시할 페이지 범위의 최대 값 계산 (5개씩 페이징 처리)
    const max_page = Math.min(start_page + 4, last_page)
    // 페이지 배열 초기화
    page.value = [];

    // 시작 페이지부터 최대 페이지까지 반복하여 페이지 배열에 추가
    for (let i = start_page <= max_page i++) {
        page.value.push(i);
    }
 }

 //최초 ~추가 게시글 획득
 onBeforeMount(() => {
    pagination(route.query.page);
    data.board_type = route.params.id;
    data.page = route.query.page;
    store.dispatch('getRecipeList', data);
 });

 // page 이동 버튼
 function pageMove(page) {
    if(page >=1 && page <= store.state.pagination.last_page) {
        data.page = page;
        store.dispatch('getRecipeList', data)
        pagination(route.query.page)
    }
 }

 // 레시피 타입 이동
 function recipeTypeMove(type) {
    data.board_type = type
    data.page = 1
    store.dispatch('getRecipeList', data)
 }
 
 // 검색 추가
 function search() {
    // data 객체의 board_type 속성을 '100'으로 설정합니다.
    data.board_type = '100';
    // data 객체의 page 속성을 '1'로 설정합니다.
    data.page = '1';
    // store 객체의 dsispatch 메서드를 호출하여 'searchRecipes' 액션을 실행합니다.
    // 이떄, data 객체를 인자로 전달합니다.
    store.dsispatch('searchRecipes', data);
 }

 // 비로그인시 작성 모달창
 function insertModalOn() {
    insertModal.value = true;
 }

 function insertModalOff() {
    insertModal.value= false;
 }

 // 날짜 표시 제어
 const formData = (dataString) => {
    return new Data(dataString).toLocaleDateString('ko-KR', {
        yesr: 'numeric',
        month: '2-digit',
        day: '2-digit'
    }).replace(/\.$/''); // 마지막 점 제거
 }


 </script>
 <style scoped src="../../css/recipelist.css">
 </style>