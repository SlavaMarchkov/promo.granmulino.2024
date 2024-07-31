import http from '@/api/http.js';
import { useAlertStore } from '@/stores/alerts.js';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';
import { convertCase, toSnakeCase } from '@/helpers/case.js';

const $toast = useToast({
    position: 'top-right',
});

const URL = '/categories';

export default {
    setCategories({ data }) {
        this.categories = data;
    },

    async all() {
        this.isContentLoading = true;
        try {
            const { data } = await http.get(URL);
            this.setCategories(data);
        } catch ( error ) {
            const alertStore = useAlertStore();
            alertStore.error(error);
        } finally {
            this.isContentLoading = false;
        }
    },

    async one(id) {
        this.isCardLoading = true;
        try {
            const { data } = await http.get(`${URL}/${id}`);
            return data;
        } catch ( error ) {
            const alertStore = useAlertStore();
            alertStore.error(error);
        } finally {
            this.isCardLoading = false;
        }
    },

    async save(item) {
        this.isButtonDisabled = true;
        const formData = convertCase(item, toSnakeCase);
        try {
            return await http.post(URL, formData);
        } catch ( error ) {
            const alertStore = useAlertStore();
            alertStore.error(error, true);
        } finally {
            this.isButtonDisabled = false;
        }
    },

    async update(item) {
        this.isButtonDisabled = true;
        const formData = convertCase(item, toSnakeCase);
        try {
            const { data } = await http.put(`${URL}/${item.id}`, formData);
            $toast.success(data.message);
            return data;
        } catch ( error ) {
            const alertStore = useAlertStore();
            alertStore.error(error, true);
        } finally {
            this.isButtonDisabled = false;
        }
    },
};
