import { createWebHistory, createRouter } from 'vue-router';
import MainComponent from '../components/MainComponent.vue';
import LoginComponent from '../components/LoginComponent.vue';
import FoodlistComponent from '../components/FoodlistComponent.vue';


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
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;