import { createWebHistory, createRouter } from 'vue-router';
import MainComponent from '../components/MainComponent.vue';
import LoginComponent from '../components/LoginComponent.vue';


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
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;