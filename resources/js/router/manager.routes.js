import { Index, Layout, Profile } from '../../views/Manager/index.js';

export default {
    path: '/',
    component: Layout,
    children: [
        {
            path: '',
            name: 'Manager.Index',
            component: Index,
            meta: {
                title: 'Главная страница',
            },
        },
        {
            path: 'profile',
            name: 'Manager.Profile',
            component: Profile,
            meta: {
                title: 'Мой профиль',
            },
        },
    ],
    meta: {
        requiresAuth: true,
        adminAuth: false,
        managerAuth: true,
    },
};
