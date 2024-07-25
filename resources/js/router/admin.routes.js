import { Layout, Index } from '../../views/Admin/index.js';

export default {
    path: '/admin',
    component: Layout,
    children: [
        {
            path: '',
            name: 'Dashboard',
            component: Index,
            meta: {
                title: 'Главная страница',
            },
        },
    ],
    meta: {
        requiresAuth: true,
    },
};
