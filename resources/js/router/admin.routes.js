import {
    Category,
    City,
    Customer,
    Index,
    Layout,
    Product,
    Region,
    Report,
    Retailer,
    User,
} from '../../views/Admin/index.js';

export default {
    path: '/admin',
    component: Layout,
    children: [
        {
            path: '',
            name: 'Admin.Index',
            component: Index,
            meta: {
                title: 'Главная страница',
            },
        },
        {
            path: 'users',
            name: 'User.Index',
            component: User,
            meta: {
                title: 'Пользователи',
            },
        },
        {
            path: 'regions',
            name: 'Region.Index',
            component: Region,
            meta: {
                title: 'Регионы',
            },
        },
        {
            path: 'cities',
            name: 'City.Index',
            component: City,
            meta: {
                title: 'Города',
            },
        },
        {
            path: 'categories',
            name: 'Category.Index',
            component: Category,
            meta: {
                title: 'Группы товаров',
            },
        },
        {
            path: 'customers',
            name: 'Customer.Index',
            component: Customer,
            meta: {
                title: 'Контрагенты',
            },
        },
        {
            path: 'products',
            name: 'Product.Index',
            component: Product,
            meta: {
                title: 'Ассортимент продукции',
            },
        },
        {
            path: 'reports',
            name: 'Report.Index',
            component: Report,
            meta: {
                title: 'Генератор отчётов',
            },
        },
        {
            path: 'retailers',
            name: 'Retailer.Index',
            component: Retailer,
            meta: {
                title: 'Торговые сети',
            },
        },
    ],
    meta: {
        requiresAuth: true,
        adminAuth: true,
        managerAuth: false,
    },
};
