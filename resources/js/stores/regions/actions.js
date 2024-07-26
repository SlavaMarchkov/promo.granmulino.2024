import http from '@/api/http.js';
import { useAlertStore } from '@/stores/alerts.js';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';
import { convertCase, toSnakeCase } from '@/helpers/case.js';

const $toast = useToast({
    position: 'top-right',
});

const URL = '/regions';

export default {
    setItems({ data }) {
        this.items = data;
    },

    async all() {
        try {
            const { data } = await http.get(URL);
            this.setItems(data);
            return data;
        } catch ( error ) {
            const alertStore = useAlertStore();
            alertStore.error(error);
        }
    },

    async one(id) {
        try {
            const { data } = await http.get(`${URL}/${id}`);
            return data;
        } catch ( error ) {
            const alertStore = useAlertStore();
            alertStore.error(error);
        }
    },

    async save(item) {
        this.isLoading = true;
        const formData = convertCase(item, toSnakeCase);
        try {
            return await http.post(URL, formData);
        } catch ( error ) {
            const alertStore = useAlertStore();
            alertStore.error(error, true);
        } finally {
            this.isLoading = false;
        }
    },

    async update(item) {
        this.isLoading = true;
        const formData = convertCase(item, toSnakeCase);
        try {
            const { data } = await http.put(`${URL}/${item.id}`, formData);
            $toast.success(data.message);
            return data;
        } catch ( error ) {
            const alertStore = useAlertStore();
            alertStore.error(error, true);
        } finally {
            this.isLoading = false;
        }
    },

    async delete(id) {
        try {
            const { data } = await http.delete(`${URL}/${id}`);
            $toast.success(data.message);
        } catch ( error ) {
            $toast.error('Ошибка при удалении: ' + error.message);
        }
    },
};
