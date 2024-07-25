import './bootstrap';
import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './components/App.vue';
import router from './router/index.js';
import { useAuthStore } from '@/stores/auth.js';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';

const pinia = createPinia();
const app = createApp(App);

app.use(pinia);
app.use(router);
app.component('Bootstrap5Pagination', Bootstrap5Pagination);

const authStore = useAuthStore();

authStore.attempt(localStorage.getItem('token'))
    .then(() => {
        app.mount('#app');
    });
