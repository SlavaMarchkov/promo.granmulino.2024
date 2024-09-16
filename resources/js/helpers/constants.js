export const RETAILER_TYPES = [
    {
        id: 'local',
        value: 'local',
        title: 'Локальная',
    },
    {
        id: 'regional',
        value: 'regional',
        title: 'Региональная',
    },
    {
        id: 'federal',
        value: 'federal',
        title: 'Федеральная',
    },
    {
        id: 'all',
        value: '',
        title: 'Все типы ТС',
    },
];

export const URLS = {
    CITY: '/admin/cities',
    REGION: '/admin/regions',
    CATEGORY: '/admin/categories',
    PRODUCT: '/admin/products',

    RETAILER: '/retailers',
    CUSTOMER: '/customers',
    USER: '/users',
};

export const RETAILER_TH_FIELDS = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'name', label: 'Название ТС', sortable: true, is_num: false },
    { column: 'label', label: 'Тип ТС', sortable: true, is_num: false },
    { column: 'customer', label: 'Контрагент', sortable: true, is_num: false },
    { column: 'city', label: 'Город', sortable: true, is_num: false },
    { column: 'isDirect', label: 'Прямой контракт?', sortable: true, is_num: true },
    { column: 'isActive', label: 'Активная?', sortable: true, is_num: true },
    { column: 'view', label: 'Просмотр', width: 10 },
    { column: 'edit', label: 'Ред.', width: 10 },
    { column: 'delete', label: 'Удалить', width: 10 },
];

export const CUSTOMER_TH_FIELDS = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'name', label: 'Название', sortable: true, is_num: false },
    { column: 'user', label: 'Менеджер', sortable: true, is_num: false },
    { column: 'region', label: 'Регион', sortable: true, is_num: false },
    { column: 'city', label: 'Город', sortable: true, is_num: false },
    { column: 'isActive', label: 'Активен?', sortable: true, is_num: true },
    { column: 'view', label: 'Просмотр', width: 10 },
    { column: 'edit', label: 'Ред.', width: 10 },
    { column: 'delete', label: 'Удалить', width: 10 },
];

export const REGION_TH_FIELDS = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'name', label: 'Название региона', sortable: true, is_num: false },
    { column: 'code', label: 'Код региона', sortable: true, is_num: false },
    { column: 'citiesCount', label: 'Количество городов', sortable: true, is_num: true },
    { column: 'view', label: 'Просмотр', width: 10 },
    { column: 'edit', label: 'Ред.', width: 10 },
    { column: 'delete', label: 'Удалить', width: 10 },
];

export const CITY_TH_FIELDS = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'name', label: 'Город', sortable: true, is_num: false },
    { column: 'regionName', label: 'Регион', sortable: true, is_num: false },
    { column: 'view', label: 'Просмотр', width: 10 },
    { column: 'edit', label: 'Ред.', width: 10 },
    { column: 'delete', label: 'Удалить', width: 10 },
];

export const CATEGORY_TH_FIELDS = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'name', label: 'Название группы товаров', sortable: true, is_num: false },
    { column: 'productsCount', label: 'Количество SKU в группе', sortable: true, is_num: true },
    { column: 'isActive', label: 'В продаже?', sortable: true, is_num: true, width: 15 },
    { column: 'view', label: 'Просмотр', width: 10 },
    { column: 'edit', label: 'Ред.', width: 10 },
    { column: 'delete', label: 'Удалить', width: 10 },
];

export const PRODUCT_TH_FIELDS = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'name', label: 'Название', sortable: true, is_num: false },
    { column: 'weight', label: 'Вес, г', sortable: true, is_num: true },
    { column: 'price', label: 'Себестоимость, руб.', sortable: true, is_num: true },
    { column: 'category', label: 'Группа товаров', sortable: true, is_num: false },
    { column: 'isActive', label: 'В продаже?', sortable: true, is_num: true, width: 15 },
    { column: 'view', label: 'Просмотр', width: 10 },
    { column: 'edit', label: 'Ред.', width: 10 },
    { column: 'delete', label: 'Удалить', width: 10 },
];

export const USER_TH_FIELDS = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'lastName', label: 'Фамилия', sortable: true, is_num: false },
    { column: 'firstName', label: 'Имя', sortable: true, is_num: false },
    { column: 'middleName', label: 'Отчество', sortable: true, is_num: false },
    { column: 'email', label: 'Email', sortable: true, is_num: false },
    { column: 'loggedInAt', label: 'Последний вход', sortable: true, is_num: false },
    { column: 'isActive', label: 'Работает?', sortable: true, is_num: true, width: 10 },
    { column: 'view', label: 'Просмотр', width: 10 },
    { column: 'edit', label: 'Ред.', width: 10 },
    { column: 'delete', label: 'Удалить', width: 10 },
];

export const MANAGER_MENU_ITEMS = [
    {
        isCollapsible: false,
        id: 'dashboard',
        route: 'Manager.Index',
        title: 'Главная страница',
        icon: 'bi bi-speedometer',
    },
    {
        isCollapsible: true,
        id: 'reports',
        title: 'Отчёты',
        icon: 'bi bi-server',
        items: [
            {
                route: 'Manager.Report.Index',
                title: 'Генератор отчётов',
            },
        ],
    },
    {
        isCollapsible: true,
        id: 'references',
        title: 'Справочники',
        icon: 'bi bi-boxes',
        items: [
            {
                route: 'Manager.Customer.Index',
                title: 'Контрагенты',
            },
            {
                route: 'Manager.Retailer.Index',
                title: 'Торговые сети',
            },
        ],
    },
    {
        isCollapsible: true,
        id: 'settings',
        title: 'Настройки',
        icon: 'bi bi-gear',
        items: [
            {
                route: 'Manager.Profile.Index',
                title: 'Мой профиль',
            },
        ],
    },
];

export const ADMIN_MENU_ITEMS = [
    {
        isCollapsible: false,
        id: 'dashboard',
        route: 'Admin.Index',
        title: 'Главная страница',
        icon: 'bi bi-speedometer',
    },
    {
        isCollapsible: true,
        id: 'reports',
        title: 'Отчёты',
        icon: 'bi bi-server',
        items: [
            {
                route: 'Report.Index',
                title: 'Генератор отчётов',
            },
        ],
    },
    {
        isCollapsible: true,
        id: 'references',
        title: 'Справочники',
        icon: 'bi bi-boxes',
        items: [
            {
                route: 'Customer.Index',
                title: 'Контрагенты',
            },
            {
                route: 'Retailer.Index',
                title: 'Торговые сети',
            },
            {
                route: 'Region.Index',
                title: 'Регионы',
            },
            {
                route: 'City.Index',
                title: 'Города',
            },
            {
                route: 'Category.Index',
                title: 'Группы товаров',
            },
            {
                route: 'Product.Index',
                title: 'Ассортимент',
            },
        ],
    },
    {
        isCollapsible: true,
        id: 'settings',
        title: 'Настройки',
        icon: 'bi bi-gear',
        items: [
            {
                route: 'User.Index',
                title: 'Пользователи',
            },
        ],
    },
];
