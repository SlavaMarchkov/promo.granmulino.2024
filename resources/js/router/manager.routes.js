import { Customer, CustomerView, Index, Layout, Profile, Retailer } from '../../views/Manager/index.js';

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
            name: 'Manager.Customer.Index',
            component: Customer,
            meta: {
                title: 'Мои контрагенты',
            },
        },
        {
            path: 'customers/:id',
            name: 'Manager.Customer.View',
            component: CustomerView,
            meta: {
                title: 'Просмотр контрагента',
            },
        },
        {
            path: 'retailers',
            name: 'Manager.Retailer.Index',
            component: Retailer,
            meta: {
                title: 'Мои торговые сети',
            },
        },
        {
            path: 'profile',
            name: 'Manager.Profile.Index',
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
