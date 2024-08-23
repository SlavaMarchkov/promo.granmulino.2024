import http from '@/api/http.js';
import { useAlertStore } from '@/stores/alerts.js';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';
import { useConvertCase } from '@/use/useConvertCase.js';

const $toast = useToast({
    position: 'top-right',
});

const { makeConvertibleObject, toSnake } = useConvertCase();

const URL = '/admin/products';

export default {
    setProducts({ data }) {
        this.products = data.data;
    },

    async all() {
        this.isContentLoading = true;
        try {
            const { data } = await http.get(URL);
            this.setProducts(data);
            $toast.success(data.message);
            return data;
        } catch ( error ) {
            const alertStore = useAlertStore();
            alertStore.error(error);
        } finally {
            this.isContentLoading = false;
        }
    },

    // TODO: show one item
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
        const formData = makeConvertibleObject(item, toSnake);
        try {
            const { data } = await http.post(URL, formData);
            $toast.success(data.message);
            return data;
        } catch ( error ) {
            const alertStore = useAlertStore();
            alertStore.error(error, true);
        } finally {
            this.isButtonDisabled = false;
        }
    },

    async update(item) {
        this.isButtonDisabled = true;
        const formData = makeConvertibleObject(item, toSnake);
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
