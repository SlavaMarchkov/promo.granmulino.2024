import { Customer, Index, Layout, Profile, Retailer } from '../../views/Manager/index.js';

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
            path: 'customers',
            name: 'Manager.Customer',
            component: Customer,
            meta: {
                title: 'Мои контрагенты',
            },
        },
        {
            path: 'retailers',
            name: 'Manager.Retailer',
            component: Retailer,
            meta: {
                title: 'Мои торговые сети',
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
