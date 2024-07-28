import http from '@/api/http.js';
import router from '@/router/index.js';
import { useAlertStore } from '@/stores/alerts.js';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';

const $toast = useToast({
    position: 'top-right',
});

export default {
    setUser(user) {
        this.user = user;
    },

    setToken(token) {
        this.token = token;
    },

    async attempt(token) {
        if ( token ) {
            this.setToken(token);
        }

        if ( !this.token ) {
            return;
        }

        try {
            const response = await http.get('/user');
            this.setUser(response.data.data);
        } catch ( error ) {
            this.setToken(null);
            this.setUser(null);
            localStorage.removeItem('token');
            const alertStore = useAlertStore();
            alertStore.error(error);
        }
    },

    async login(credentials) {
        this.isLoading = true;
        try {
            const response = await http.post('/login', credentials);
            await this.attempt(response.data.token);
            $toast.success(response.data.message);
            await router.push({
                name: 'Dashboard',
            });
        } catch ( error ) {
            const alertStore = useAlertStore();
            alertStore.error(error);
        } finally {
            this.isLoading = false;
        }
    },

    async register(credentials) {
        this.isLoading = true;
        try {
            const response = await http.post('/register', credentials);
            $toast.success(response.data.message);
            await router.push({
                name: 'Login',
            });
        } catch ( error ) {
            const alertStore = useAlertStore();
            alertStore.error(error);
        } finally {
            this.isLoading = false;
        }
    },

    async logout() {
        try {
            const response = await http.post('/logout');
            this.setToken(null);
            this.setUser(null);
            localStorage.removeItem('token');

            $toast.success(response.data.message);
            await router.push({
                name: 'Login',
            });
        } catch ( error ) {
            this.setToken(null);
            this.setUser(null);
            localStorage.removeItem('token');

            const alertStore = useAlertStore();
            alertStore.error(error);
        }
    },
};
