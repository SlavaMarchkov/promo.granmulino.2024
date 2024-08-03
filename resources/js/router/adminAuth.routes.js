import { AdminLogin, Layout } from '../../views/Auth/index.js';

export default {
    path: '/admin',
    component: Layout,
    children: [
        {
            path: '/admin',
            redirect: '/admin/login',
        },
        {
            path: 'login',
            name: 'AdminLogin',
            component: AdminLogin,
            meta: {
                title: 'Вход в админку',
            },
        },
    ],
    meta: {
        requiresGuest: true,
    },
};
