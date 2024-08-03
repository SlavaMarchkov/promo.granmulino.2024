import { Layout, Login } from '../../views/Auth/index.js';

export default {
    path: '/',
    component: Layout,
    children: [
        {
            path: '',
            redirect: '/login',
        },
        {
            path: 'login',
            name: 'Login',
            component: Login,
            meta: {
                title: 'Вход в систему',
            },
        },
    ],
    meta: {
        requiresGuest: true,
    },
};
