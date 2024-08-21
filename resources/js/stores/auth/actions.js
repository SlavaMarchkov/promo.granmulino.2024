import http from '@/api/http.js';
import router from '@/router/index.js';
import { useAlertStore } from '@/stores/alerts.js';
import { resetAllPiniaStores } from '@/use/useResetStore.js';
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

    async loadUser(token, isAdmin) {
        if ( token ) {
            this.setToken(token);
        }

        if ( !this.token ) {
            return;
        }

        const path = isAdmin ? '/admin/user' : '/user';

        try {
            const { data } = await http.get(path);
            this.setUser(data);
            localStorage.setItem('user', JSON.stringify(data));
        } catch ( error ) {
            this.setToken(null);
            this.setUser(null);
            localStorage.removeItem('token');
            localStorage.removeItem('user');
        }
    },

    async login(credentials) {
        this.isLoading = true;
        try {
            const { data } = await http.post('/login', credentials);
            await this.loadUser(data.token, false);
            $toast.success(data.message);
            await router.push({
                name: 'Manager.Index',
            });
        } catch ( error ) {
            const alertStore = useAlertStore();
            alertStore.error(error);
        } finally {
            this.isLoading = false;
        }
    },

    async adminLogin(credentials) {
        this.isLoading = true;
        try {
            const { data } = await http.post('/admin/login', credentials);
            await this.loadUser(data.token, true);
            $toast.success(data.message);
            await router.push({
                name: 'Admin.Index',
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
            localStorage.removeItem('user');

            $toast.success(response.data.message);

            resetAllPiniaStores();

            await router.push({
                name: 'Login',
            });
        } catch ( error ) {
            this.setToken(null);
            this.setUser(null);
            localStorage.removeItem('token');
            localStorage.removeItem('user');

            const alertStore = useAlertStore();
            alertStore.error(error);
        }
    },

    async adminLogout() {
        try {
            const response = await http.post('/admin/logout');

            this.setToken(null);
            this.setUser(null);
            localStorage.removeItem('token');
            localStorage.removeItem('user');

            $toast.success(response.data.message);

            resetAllPiniaStores();

            await router.push({
                name: 'AdminLogin',
            });
        } catch ( error ) {
            this.setToken(null);
            this.setUser(null);
            localStorage.removeItem('token');
            localStorage.removeItem('user');

            const alertStore = useAlertStore();
            alertStore.error(error);
        }
    },
};
