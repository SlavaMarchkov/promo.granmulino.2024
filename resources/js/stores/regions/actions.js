import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-bootstrap.css';
import { useHttpService } from '@/use/useHttpService.js';

const $toast = useToast({
    position: 'top-right',
});

const URL = '/admin/regions';

export default {
    setRegions(data) {
        this.regions = data;
    },

    async all() {
        const { get } = useHttpService();
        const { data } = await get(URL);
        this.setRegions(data.regions);
    },

    async one(id) {
        const { get } = useHttpService();
        return await get(`${URL}/${id}`);
    },

    async save(item) {
        const { post } = useHttpService();
        return await post(URL, item, {
            method: 'POST',
        });
    },

    async update(item) {
        const { post } = useHttpService();
        return await post(`${URL}/${item.id}`, item, {
            method: 'PUT',
        });
    },

    async delete(id) {
        const { post } = useHttpService();
        return await post(`${URL}/${item.id}`, null, {
            method: 'DELETE',
        });
    },
};
