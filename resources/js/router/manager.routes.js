import { Customer, Index, Layout, Profile, Retailer } from '../../views/Manager/index.js';
import { Report } from '../../views/Admin/index.js';

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
        {
            path: 'reports',
            name: 'Manager.Report.Index',
            component: Report,
            meta: {
                title: 'Генератор отчётов',
            },
        },
    ],
    meta: {
        requiresAuth: true,
        adminAuth: false,
        managerAuth: true,
    },
};
