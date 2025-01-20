import Layout from '../../views/Admin/Layout.vue';

export default {
    path: '/admin',
    component: Layout,
    children: [
        {
            path: '',
            name: 'Admin.Index',
            component: () => import('../../views/Admin/Index.vue'),
            meta: {
                title: 'Главная страница',
            },
        },
        {
            path: 'administrators',
            name: 'Administrator.Index',
            component: () => import('../../views/Admin/Administrator/Index.vue'),
            meta: {
                title: 'Администраторы',
            },
        },
        {
            path: 'categories',
            name: 'Category.Index',
            component: () => import('../../views/Admin/Category/Index.vue'),
            meta: {
                title: 'Группы товаров',
            },
        },
        {
            path: 'categories/:id',
            name: 'Category.View',
            component: () => import('../../views/Admin/Category/View.vue'),
            meta: {
                title: 'Просмотр группы товаров',
            },
        },
        {
            path: 'cities',
            name: 'City.Index',
            component: () => import('../../views/Admin/City/Index.vue'),
            meta: {
                title: 'Города',
            },
        },
        {
            path: 'cities/:id',
            name: 'City.View',
            component: () => import('../../views/Admin/City/View.vue'),
            meta: {
                title: 'Просмотр города',
            },
        },
        {
            path: 'customers',
            name: 'Customer.Index',
            component: () => import('../../views/Admin/Customer/Index.vue'),
            meta: {
                title: 'Контрагенты',
            },
        },
        {
            path: 'customers/:id',
            name: 'Customer.View',
            component: () => import('../../views/Admin/Customer/View.vue'),
            meta: {
                title: 'Просмотр контрагента',
            },
        },
        {
            path: 'notifications',
            name: 'Notification.Index',
            component: () => import('../../views/Admin/Notification/Index.vue'),
            meta: {
                title: 'Уведомления',
            },
        },
        {
            path: 'products',
            name: 'Product.Index',
            component: () => import('../../views/Admin/Product/Index.vue'),
            meta: {
                title: 'Ассортимент продукции',
            },
        },
        {
            path: 'products/:id',
            name: 'Product.View',
            component: () => import('../../views/Admin/Product/View.vue'),
            meta: {
                title: 'Просмотр продукта',
            },
        },
        {
            path: 'promo',
            name: 'Promo.Index',
            component: () => import('../../views/Admin/Promo/Index.vue'),
            meta: {
                title: 'Промо-акции',
            },
        },
        {
            path: 'promos/:id',
            name: 'Promo.View',
            component: () => import('../../views/Admin/Promo/View.vue'),
            meta: {
                title: 'Просмотр промо-акции',
            },
        },
        {
            path: 'regions',
            name: 'Region.Index',
            component: () => import('../../views/Admin/Region/Index.vue'),
            meta: {
                title: 'Регионы',
            },
        },
        {
            path: 'regions/:id',
            name: 'Region.View',
            component: () => import('../../views/Admin/Region/View.vue'),
            meta: {
                title: 'Просмотр региона',
            },
        },
        {
            path: 'reports',
            name: 'Report.Index',
            component: () => import('../../views/Admin/Report/Index.vue'),
            meta: {
                title: 'Генератор отчётов',
            },
        },
        {
            path: 'retailers',
            name: 'Retailer.Index',
            component: () => import('../../views/Admin/Retailer/Index.vue'),
            meta: {
                title: 'Торговые сети',
            },
        },
        {
            path: 'retailers/:id',
            name: 'Retailer.View',
            component: () => import('../../views/Admin/Retailer/View.vue'),
            meta: {
                title: 'Просмотр торговой сети',
            },
        },
        {
            path: 'sales',
            name: 'Sales.Index',
            component: () => import('../../views/Admin/Sales/Index.vue'),
            meta: {
                title: 'Продажи',
            },
        },
        {
            path: 'users',
            name: 'User.Index',
            component: () => import('../../views/Admin/User/Index.vue'),
            meta: {
                title: 'Пользователи',
            },
        },
        {
            path: 'users/:id',
            name: 'User.View',
            component: () => import('../../views/Admin/User/View.vue'),
            meta: {
                title: 'Просмотр пользователя',
            },
        },
    ],
    meta: {
        requiresAuth: true,
        adminAuth: true,
        managerAuth: false,
    },
};
