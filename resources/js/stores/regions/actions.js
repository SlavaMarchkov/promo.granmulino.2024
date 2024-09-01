import { useHttpService } from '@/use/useHttpService.js';

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
        return await post(URL, item);
    },

    async update(item) {
        const { update } = useHttpService();
        return await update(`${URL}/${item.id}`, item);
    },

    async delete(id) {
        const { destroy } = useHttpService();
        return await destroy(`${URL}/${id}`);
    },
};
