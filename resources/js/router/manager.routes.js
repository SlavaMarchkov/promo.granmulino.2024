import {
    Customer,
    CustomerView,
    Index,
    Layout,
    Profile,
    Promo,
    PromoCreate,
    Retailer,
} from '../../views/Manager/index.js';

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
        {
            path: 'promo',
            name: 'Manager.Promo.Index',
            component: Promo,
            meta: {
                title: 'Мои промо-акции',
            },
        },
        {
            path: 'promo/create',
            name: 'Manager.Promo.Create',
            component: PromoCreate,
            meta: {
                title: 'Новая промо-акция',
            },
        },
    ],
    meta: {
        requiresAuth: true,
        adminAuth: false,
        managerAuth: true,
    },
};
