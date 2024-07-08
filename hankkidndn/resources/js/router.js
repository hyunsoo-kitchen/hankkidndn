import { createWebHistory, createRouter } from 'vue-router';
import MainComponent from '../components/CommonPage/MainComponent.vue';
import LoginComponent from '../components/UserPage/LoginComponent.vue';
import RecipeListComponent from '../components/RecipePage/RecipeListComponent.vue';
import RecipeDetailComponent from '../components/RecipePage/RecipeDetailComponent.vue';
import RecipeInsertComponent from '../components/RecipePage/RecipeInsertComponent.vue';
import RecipeUpdateComponent from '../components/RecipePage/RecipeUpdateComponent.vue';
import BoardListComponent from '../components/BoardPage/BoardListComponent.vue';
import BoardInsertComponent from '../components/BoardPage/BoardInsertComponent.vue';
import BoardUpdateComponent from '../components/BoardPage/BoardUpdateComponent.vue';
import BoardDetailComponent from '../components/BoardPage/BoardDetailComponent.vue';
import RegistComponent from '../components/UserPage/RegistComponent.vue';
import RegistAgreeComponent from '../components/UserPage/RegistAgreeComponent.vue';
import RegistCompliteComponent from '../components/UserPage/ConfirmationModal.vue';
import MypageComponent from '../components/Mypage/MypageComponent.vue';
import MypageCommentComponent from '../components/Mypage/MypageCommentComponent.vue';
import MypageRecipeComponent from '../components/Mypage/MypageRecipeComponent.vue';
import SearchRecipeListComponent from '../components/RecipePage/SearchRecipeListComponent.vue'
import SearchBoardListComponent from '../components/BoardPage/SearchBoardListComponent.vue';
import store from './store';
import RegistrationComplete from '../components/UserPage/RegistrationComplete.vue';
import AdminLogin from '../components/AdminPage/AdminLogin.vue';
import AdminAdComponent from '../components/AdminPage/AdminAdComponent.vue';
import AdminNoticeComponent from '../components/AdminPage/AdminNoticeComponent.vue';
import BoardNoticeListComponent from '../components/BoardPage/BoardNoticeListComponent.vue';
import ContentControllComponent from '../components/AdminPage/ContentControllComponent.vue';
import KakaoLoginComponent from '../components/UserPage/KakaoLoginComponent.vue';
import BoardNoticeDetailComponent from '../components/BoardPage/BoardNoticeDetailComponent.vue';
import BoardNoticeUpdateComponent from '../components/BoardPage/BoardNoticeUpdateComponent.vue';
import AdminEventComponent from '../components/AdminPage/AdminEventComponent.vue';

const routes = [
    {
        path: '/',
        redirect: '/main',
    },
    {
        path: '/main',
        component: MainComponent,
    },
    {
        path: '/login',
        component: LoginComponent,
        beforeEnter: chkAuthon,
    },
    {
        path: '/regist',
        component: RegistComponent,
        beforeEnter: chkAuthon,
    },
    {
        path: '/regist/agree',
        component: RegistAgreeComponent,
        beforeEnter: chkAuthon,
    },
    {
        path: '/regist/comp',
        component: RegistCompliteComponent,
        beforeEnter: chkAuthon,
    },
    {
        path: '/recipe/:id',
        component: RecipeListComponent,
        beforeEnter:  [chkPageNum, chkRecipeType]
    },
    {
        path: '/recipe/insert',
        component: RecipeInsertComponent,
        beforeEnter: chkAuth,
    },
    {
        path: '/recipe/update/:id',
        component: RecipeUpdateComponent,
        beforeEnter: chkAuth,
    },
    {
        path: '/recipe/detail/:id',
        component: RecipeDetailComponent,
        beforeEnter: recipeViews,
    },
    {
        path: '/board/:id',
        component: BoardListComponent,
        beforeEnter:  [chkPageNum, chkBoardType]
    },
    {
        path: '/board/insert',
        component: BoardInsertComponent,
        beforeEnter: chkAuth,
    },
    {
        path: '/board/update/:id',
        component: BoardUpdateComponent,
        beforeEnter: chkAuth,
    },
    {
        path: '/board/detail/:id',
        component: BoardDetailComponent,
        beforeEnter: boardViews,
    },
    {
        path: '/mypage',
        component: MypageRecipeComponent,
        beforeEnter: chkAuth,
    },
    {
        path: '/mypage/update',
        component: MypageComponent, 
        beforeEnter: chkAuth,
    },
    {
        path: '/mypage/comments',
        component: MypageCommentComponent,
        beforeEnter: chkAuth,
    },
    {
        path: '/search/recipe',
        component: SearchRecipeListComponent,
        beforeEnter:  chkSearchPageNum
    },
    {
        path: '/search/board/:id/:search',
        component: SearchBoardListComponent,
        beforeEnter:  [chkSearchPageNum, chkBoardType]
    },
    {
        path: '/registrationcomplete',
        component: RegistrationComplete,
    },
    // 관리자 처리 --- 노경호
    {
        path: '/adminlogin',
        component: AdminLogin,
        beforeEnter: chkAdminOn,
    },
    {
        path: '/admincontentcontroll',
        component: ContentControllComponent,
        beforeEnter: chkAdmin,
    },
    {
        path: '/adminnotice',
        component: AdminNoticeComponent,
        beforeEnter: [chkAdmin, chkNoticePageNum]
    },
    {
        path: '/board/notice',
        component: BoardNoticeListComponent,
        beforeEnter: chkNoticePageNum,
    },
    {
        path: '/adminevent',
        component: AdminEventComponent,
        beforeEnter: chkAdmin,
    },
    {
        path: '/board/notice/detail/:id',
        component: BoardNoticeDetailComponent,
    },
    {
        path: '/board/notice/update/:id',
        component: BoardNoticeUpdateComponent,
        beforeEnter: chkAdmin,
    },
    {
        path: '/adminad',
        component: AdminAdComponent,
        beforeEnter: chkAdmin,
    },
    {
        path: '/kakaoLogin',
        component: KakaoLoginComponent,
    },
];

const router = createRouter({
    // 뒤로가기 했을때는 스크롤 위치 저장, 그 외는 최상단으로
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
          return savedPosition
        } else {
          return { top: 0 }
        }
      },
    history: createWebHistory(),
    routes,
});

// 비로그인시 못가는 페이지 처리
function chkAuth(to, from, next) {
    if(store.state.authFlg || store.state.adminFlg) {
        next();
    } else {
        alert('로그인이 필요한 서비스입니다.');
        next('/login');
    }
};

// 로그인시 못가는 페이지 처리
function chkAuthon(to, from, next) {
    if(!(store.state.authFlg)) {
        next();
    } else {
        alert('로그인 상태에서는 접속 할 수 없습니다.');
        next('/main');
    }
};

// 관리자 로그인 상태가 아닐때 못가는 페이지 처리
function chkAdmin(to, from, next) {
    if(store.state.adminFlg) {
        next();
    } else {
        next('/main');
    }
}

// 관리자 로그인시 못가는 페이지 처리
function chkAdminOn(to, from, next) {
    if(!store.state.adminFlg) {
        next();
    } else {
        next('/admincontentcontroll');
    }
}

// 보드 게시판 타입 관리
function chkBoardType(to, from, next) {
    if(to.params.id >= 10 || to.params.id <= 6 || isNaN(to.params.id)) {
        alert('해당 게시판은 없는 게시판 입니다.');
        router.back();
    } else {
        next();
    }
}

// 레시피 게시판 타입 관리
function chkRecipeType(to, from, next) {
    if(to.params.id >= 1 && to.params.id <= 5 || to.params.id == 100 || to.params.id == 99 || isNaN(to.params.id)) {
        next();
    } else {
        alert('해당 게시판은 없는 게시판 입니다.');
        router.back();
    }
}

// 게시글 페이지 초과시 처리
function chkPageNum(to, from, next) {
    if(to.query.page > store.state.pagination.last_page || to.query.page < 1 || isNaN(to.query.page)) {
        alert('해당 페이지는 없는 페이지 입니다.');
        router.back();
    } else {
        next();
    }
}

// 관리자 공지사항 페이지 초과시 처리
function chkNoticePageNum(to, from, next) {
    if(to.query.page > store.state.noticePagination.last_page || to.query.page < 1 || isNaN(to.query.page)) {
        alert('해당 페이지는 없는 페이지 입니다.');
        router.back();
    } else {
        next();
    }
}

// 게시글 검색 페이지 초과시 처리
function chkSearchPageNum(to, from, next) {
    if(to.query.page > store.state.searchPagination.last_page || to.query.page < 1 || isNaN(to.query.page)) {
        alert('해당 페이지는 없는 페이지 입니다.');
        router.back();
    } else {
        next();
    }
}

// 조회수 업데이트
function boardViews(to, from, next) {
    store.dispatch('boardViewUp', to.params.id)
    next();
}

function recipeViews(to, from, next) {
    store.dispatch('recipeViewUp', to.params.id)
    next();
}
export default router;