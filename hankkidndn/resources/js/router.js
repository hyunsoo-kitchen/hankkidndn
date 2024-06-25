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
import RegistCompliteComponent from '../components/UserPage/RegistCompliteComponent.vue';
import MypageComponent from '../components/Mypage/MypageComponent.vue';
import MypageCommentComponent from '../components/Mypage/MypageCommentComponent.vue';
import MypageRecipeComponent from '../components/Mypage/MypageRecipeComponent.vue';
import SearchRecipeListComponent from '../components/RecipePage/SearchRecipeListComponent.vue'
import SearchBoardListComponent from '../components/BoardPage/SearchBoardListComponent.vue';
import store from './store';

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
        beforeEnter: chkRecipeDetail,
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
    },
    {
        path: '/search/board/:id/:search',
        component: SearchBoardListComponent,
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
    if(store.state.authFlg) {
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

// 보드 게시판 타입 관리
function chkBoardType(to, from, next) {
    if(to.params.id >= 10 || to.params.id <= 5) {
        alert('해당 게시판은 없는 게시판 입니다.');
        router.back();
    } else {
        next();
    }
}

// 레시피 게시판 타입 관리
function chkRecipeType(to, from, next) {
    if(to.params.id >= 1 && to.params.id <= 5 || to.params.id == 100) {
        next();
    } else {
        alert('해당 게시판은 없는 게시판 입니다.');
        router.back();
    }
}

// 게시글 페이지 초과시 처리
function chkPageNum(to, from, next) {
    if(to.query.page > store.state.pagination.last_page || to.query.page < 1 ) {
        alert('해당 페이지는 없는 페이지 입니다.');
        router.back();
    } else {
        next();
    }
}

function chkRecipeDetail(to, from, next) {
    const url = '/api/recipe/route/' + to.params.id

    console.log(to.params.id)

    axios.get(url)
    .then(response => {
        next()
    })
    .catch(error => {
        if (error.response) {
            // 서버가 요청을 받았지만 오류 응답을 반환함 (예: 4xx, 5xx 상태 코드)
            console.error('Server Error:', error.response.data);
            alert('서버 오류가 발생했습니다.');
        }
    })
}
export default router;