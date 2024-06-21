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
    },
    {
        path: '/regist',
        component: RegistComponent,
    },
    {
        path: '/regist/agree',
        component: RegistAgreeComponent,
    },
    {
        path: '/regist/comp',
        component: RegistCompliteComponent,
    },
    {
        path: '/recipe/:id',
        component: RecipeListComponent,
    },
    {
        path: '/recipe/insert',
        component: RecipeInsertComponent,
    },
    {
        path: '/recipe/update',
        component: RecipeUpdateComponent,
    },
    {
        path: '/recipe/detail',
        component: RecipeDetailComponent,
    },
    {
        path: '/board/:id',
        component: BoardListComponent,
    },
    {
        path: '/board/insert',
        component: BoardInsertComponent,
    },
    {
        path: '/board/update/:id',
        component: BoardUpdateComponent,
    },
    {
        path: '/board/detail/:id',
        component: BoardDetailComponent,
    },
    {
        path: '/mypage',
        component: MypageRecipeComponent,
    },
    {
        path: '/mypage/update',
        component: MypageComponent, 
    },
    {
        path: '/mypage/comments',
        component: MypageCommentComponent,
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

export default router;