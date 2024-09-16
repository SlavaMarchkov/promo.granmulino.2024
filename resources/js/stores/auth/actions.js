import http from '@/api/http.js';
import router from '@/router/index.js';
import { useAlertStore } from '@/stores/alerts.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { resetAllPiniaStores } from '@/use/useResetStore.js';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';

const $toast = useToast({
    position: 'top-right',
});

export default {
    setUser(data) {
        this.user = data;
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
            this.setUser(data.data);
            localStorage.setItem('user', JSON.stringify(data.data));
        } catch ( error ) {
            this.setToken(null);
            this.setUser(null);
            localStorage.removeItem('token');
            localStorage.removeItem('user');
        }
    },

    async login(credentials) {
        const spinnerStore = useSpinnerStore();
        spinnerStore.showSpinner();
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
            spinnerStore.hideSpinner();
        }
    },

    async adminLogin(credentials) {
        const spinnerStore = useSpinnerStore();
        spinnerStore.showSpinner();
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
            spinnerStore.hideSpinner();
        }
    },

    async logout() {
        try {
            const response = await http.post('/logout');

            localStorage.removeItem('token');
            localStorage.removeItem('user');
            this.clear();

            $toast.success(response.data.message);

            resetAllPiniaStores();

            await router.push({
                name: 'Login',
            });
        } catch ( error ) {
            this.clear();
            localStorage.removeItem('token');
            localStorage.removeItem('user');

            const alertStore = useAlertStore();
            alertStore.error(error);
        }
    },

    async adminLogout() {
        try {
            const response = await http.post('/admin/logout');

            localStorage.removeItem('token');
            localStorage.removeItem('user');
            this.clear();

            $toast.success(response.data.message);

            resetAllPiniaStores();

            await router.push({
                name: 'AdminLogin',
            });
        } catch ( error ) {
            this.clear();
            localStorage.removeItem('token');
            localStorage.removeItem('user');

            const alertStore = useAlertStore();
            alertStore.error(error);
        }
    },

    clear() {
        this.user = null;
        this.token = null;
    },
};
