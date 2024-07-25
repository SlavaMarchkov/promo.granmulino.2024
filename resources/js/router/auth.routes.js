import { Layout, Login, Register } from '../../views/Auth/index.js';

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
        {
            path: 'register',
            name: 'Register',
            component: Register,
            meta: {
                title: 'Регистрация',
            },
        },
    ],
    meta: {
        requiresGuest: true,
    },
};
