import http from '@/api/http.js';
import { useAlertStore } from '@/stores/alerts.js';
import { useSpinnerStore } from '@/stores/spinners.js';
import { resetAllPiniaStores } from '@/use/useResetStore.js';

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

        try {
            const { data } = await http.get(`${ isAdmin ? '/admin/user' : '/user' }`);
            this.setUser(data.data);
            localStorage.setItem('user', JSON.stringify(data.data));
        } catch ( error ) {
            this.setToken(null);
            this.setUser(null);
            localStorage.removeItem('token');
            localStorage.removeItem('user');
        }
    },

    async login(credentials, isAdmin = false) {
        const spinnerStore = useSpinnerStore();
        spinnerStore.showSpinner();
        try {
            const { data } = await http.post(`${ isAdmin ? '/admin/login' : '/login' }`, credentials);
            await this.loadUser(data.data.token, isAdmin);
            return data;
        } catch ( error ) {
            const alertStore = useAlertStore();
            alertStore.error(error);
        } finally {
            spinnerStore.hideSpinner();
        }
    },

    async logout(isAdmin = false) {
        try {
            const { data } = await http.post(`${ isAdmin ? '/admin/logout' : '/logout' }`);

            localStorage.removeItem('token');
            localStorage.removeItem('user');
            this.clear();

            resetAllPiniaStores();

            return data;
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
