import { createWebHistory, createRouter } from 'vue-router';
import MainComponent from '../components/CommonPage/CategoryComponent.vue';
import LoginComponent from '../components/UserPage/LoginComponent.vue';
import FoodlistComponent from '../components/RecipePage/RecipeListComponent.vue';
import DetailComponent from '../components/RecipePage/RecipeDetailComponent.vue';


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
        path: '/detail',
        component: DetailComponent,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;