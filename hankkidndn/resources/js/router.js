import { createWebHistory, createRouter } from 'vue-router';
import MainComponent from '../components/MainComponent.vue';
import JoinComponent from '../components/JoinComponent.vue';


const routes = [
    {
        path: '/',
        redirect: '/main',
    },
    {
        path: '/main',
        component: MainComponent,
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;