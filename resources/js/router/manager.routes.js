import Layout from '../../views/Manager/Layout.vue';

export default {
    path: '/',
    component: Layout,
    children: [
        {
            path: '',
            name: 'Manager.Index',
            component: () => import('../../views/Manager/Index.vue'),
            meta: {
                title: 'Главная страница',
            },
        },
        {
            path: 'customers',
            name: 'Manager.Customer.Index',
            component: () => import('../../views/Manager/Customer/Index.vue'),
            meta: {
                title: 'Мои контрагенты',
            },
        },
        {
            path: 'customers/:id',
            name: 'Manager.Customer.View',
            component: () => import('../../views/Manager/Customer/View.vue'),
            meta: {
                title: 'Просмотр контрагента',
            },
        },
        {
            path: 'retailers',
            name: 'Manager.Retailer.Index',
            component: () => import('../../views/Manager/Retailer/Index.vue'),
            meta: {
                title: 'Мои торговые сети',
            },
        },
        {
            path: 'retailers/:id',
            name: 'Manager.Retailer.View',
            component: () => import('../../views/Manager/Retailer/View.vue'),
            meta: {
                title: 'Просмотр торговой сети',
            },
        },
        {
            path: 'profile',
            name: 'Manager.Profile.Index',
            component: () => import('../../views/Manager/Profile/Index.vue'),
            meta: {
                title: 'Мой профиль',
            },
        },
        {
            path: 'promo',
            name: 'Manager.Promo.Index',
            component: () => import('../../views/Manager/Promo/Index.vue'),
            meta: {
                title: 'Мои промо-акции',
            },
        },
        {
            path: 'promo/create',
            name: 'Manager.Promo.Create',
            component: () => import('../../views/Manager/Promo/Create.vue'),
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
