import { createWebHistory, createRouter } from 'vue-router';
import MainComponent from '../components/CommonPage/MainComponent.vue';
import LoginComponent from '../components/UserPage/LoginComponent.vue';
import FoodlistComponent from '../components/RecipePage/RecipeListComponent.vue';
import RecipeDetailComponent from '../components/RecipePage/RecipeDetailComponent.vue';
import RecipeInsertComponent from '../components/RecipePage/RecipeInsertComponent.vue';
import RecipeUpdateComponent from '../components/RecipePage/RecipeUpdateComponent.vue';


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
        path: '/recipelist',
        component: FoodlistComponent,
    },
    {
        path: '/recipeinsert',
        component: RecipeInsertComponent,
    },
    {
        path: '/recipeupdate',
        component: RecipeUpdateComponent,
    },
    {
        path: '/recipedetail',
        component: RecipeDetailComponent,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;