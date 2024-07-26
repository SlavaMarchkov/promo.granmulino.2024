import { Category, City, Index, Layout, Product, Region, Report, User } from '../../views/Admin/index.js';

export default {
    path: '/admin',
    component: Layout,
    children: [
        {
            path: '',
            name: 'Dashboard',
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
    ],
    meta: {
        requiresAuth: true,
    },
};
