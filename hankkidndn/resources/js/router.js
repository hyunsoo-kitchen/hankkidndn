import { createWebHistory, createRouter } from 'vue-router';
import store from './store'


const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;