require('./bootstrap');

import { createApp } from 'vue';
import router from './router';
import store from './store.js';
import AppComponent from '../components/AppComponent.vue';
import JoinComponent from '../components/JoinComponent.vue';

createApp({
    components: {
        AppComponent,
        JoinComponent
    }
})
.use(router)
.use(store)
.mount('#app');