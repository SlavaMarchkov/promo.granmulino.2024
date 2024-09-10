import {
    Category,
    City,
    Customer,
    CustomerView,
    Index,
    Layout,
    Product,
    ProductView,
    Region,
    RegionView,
    Report,
    Retailer,
    RetailerView,
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
            path: 'regions/:id',
            name: 'Region.View',
            component: RegionView,
            meta: {
                title: 'Просмотр региона',
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
            path: 'customers/:id',
            name: 'Customer.View',
            component: CustomerView,
            meta: {
                title: 'Просмотр контрагента',
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
            path: 'products/:id',
            name: 'Product.View',
            component: ProductView,
            meta: {
                title: 'Просмотр продукта',
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
        {
            path: 'retailers/:id',
            name: 'Retailer.View',
            component: RetailerView,
            meta: {
                title: 'Просмотр торговой сети',
            },
        },
    ],
    meta: {
        requiresAuth: true,
        adminAuth: true,
        managerAuth: false,
    },
};
