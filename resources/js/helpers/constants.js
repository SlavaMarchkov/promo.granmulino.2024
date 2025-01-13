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

export const PROMO_TYPES = [
    {
        isForRetail: true,
        type: 'DISCOUNT',
        title: 'Скидка в цене',
        code: 'ЖЦ',
    },
    {
        isForRetail: false,
        type: 'SALES_PEOPLE_BOOST',
        title: 'Мотивация торгового персонала',
        code: 'МТП',
    },
    {
        isForRetail: true,
        type: 'GIFT_FOR_PURCHASE',
        title: 'Подарок за покупку',
        code: 'ПП',
    },
    {
        isForRetail: false,
        type: 'RETAILERS_BOOST',
        title: 'Мотивация розничных точек',
        code: 'МРТ',
    },
    {
        isForRetail: false,
        type: 'COVERAGE_INCREASE',
        title: 'Увеличение покрытия',
        code: 'УП',
    },
    {
        isForRetail: true,
        type: 'IN_OUT',
        title: 'Временный ввод в матрицу сети In-Out',
        code: 'IN-OUT',
    },
];

export const ROLES = {
    SUPER_ADMIN: 'SUPER_ADMIN',
    PRICE_ADMIN: 'PRICE_ADMIN',
    ADMIN: 'ADMIN',
    MANAGER: 'MANAGER',
};

export const ADMIN_URLS = {
    CATEGORY: '/admin/categories',
    CITY: '/admin/cities',
    CUSTOMER: '/admin/customers',
    PRODUCT: '/admin/products',
    REGION: '/admin/regions',
    RETAILER: '/admin/retailers',
    USER: '/admin/users',
};

export const MANAGER_URLS = {
    CATEGORY: '/categories',
    CHANNEL: '/channels',
    CUSTOMER: '/customers',
    MARK: '/marks',
    PRODUCT: '/products',
    PROMO: '/promos',
    SELLER: '/sellers',
    RETAILER: '/retailers',
    USER: '/users',
};

export const EDIT_TH_FIELD = [
    { column: 'edit', label: 'Ред.', sortable: false, is_num: false, width: 10 },
];

export const DELETE_TH_FIELD = [
    { column: 'delete', label: 'Удалить', sortable: false, is_num: false, width: 10 },
];

export const PRICE_TH_FIELD = [
    { column: 'price', label: 'Себестоимость, руб.', sortable: true, is_num: true },
];

export const RETAILER_TH_FIELDS = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'name', label: 'Название ТС', sortable: true, is_num: false },
    { column: 'label', label: 'Тип ТС', sortable: true, is_num: false },
    { column: 'customer', label: 'Контрагент', sortable: true, is_num: false },
    { column: 'city', label: 'Город', sortable: true, is_num: false },
    { column: 'isDirect', label: 'Прямой контракт?', sortable: true, is_num: true },
    { column: 'isActive', label: 'Активная?', sortable: true, is_num: true },
    { column: 'view', label: 'Просмотр', sortable: false, is_num: false, width: 10 },
];

export const CUSTOMER_TH_FIELDS = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'name', label: 'Название', sortable: true, is_num: false },
    { column: 'userName', label: 'Менеджер', sortable: true, is_num: false },
    { column: 'regionName', label: 'Регион', sortable: true, is_num: false },
    { column: 'cityName', label: 'Город', sortable: true, is_num: false },
    { column: 'isActive', label: 'Активен?', sortable: true, is_num: true },
    { column: 'view', label: 'Просмотр', sortable: false, is_num: false, width: 10 },
];

export const REGION_TH_FIELDS = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'name', label: 'Название региона', sortable: true, is_num: false },
    { column: 'code', label: 'Код региона', sortable: true, is_num: false },
    { column: 'citiesCount', label: 'Количество городов', sortable: true, is_num: true },
    { column: 'view', label: 'Просмотр', sortable: false, is_num: false, width: 10 },
];

export const CITY_TH_FIELDS = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'name', label: 'Город', sortable: true, is_num: false },
    { column: 'latitude', label: 'Широта', sortable: true, is_num: true },
    { column: 'longitude', label: 'Долгота', sortable: true, is_num: true },
    { column: 'state', label: 'Локация (EN)', sortable: true, is_num: false },
    { column: 'regionName', label: 'Регион', sortable: true, is_num: false },
    { column: 'view', label: 'Просмотр', sortable: false, is_num: false, width: 10 },
];

export const CATEGORY_TH_FIELDS = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'name', label: 'Название группы товаров', sortable: true, is_num: false },
    { column: 'productsCount', label: 'Количество SKU в группе', sortable: true, is_num: true },
    { column: 'isActive', label: 'В продаже?', sortable: true, is_num: true, width: 15 },
    { column: 'view', label: 'Просмотр', sortable: false, is_num: false, width: 10 },
];

export const PRODUCT_TH_FIELDS = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'name', label: 'Название', sortable: true, is_num: false },
    { column: 'weight', label: 'Вес, г', sortable: true, is_num: true },
    { column: 'categoryName', label: 'Группа товаров', sortable: true, is_num: false },
    { column: 'isActive', label: 'В продаже?', sortable: true, is_num: true, width: 15 },
    { column: 'view', label: 'Просмотр', sortable: false, is_num: false, width: 10 },
];

export const USER_TH_FIELDS = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'lastName', label: 'Фамилия', sortable: true, is_num: false },
    { column: 'firstName', label: 'Имя', sortable: true, is_num: false },
    { column: 'middleName', label: 'Отчество', sortable: true, is_num: false },
    { column: 'email', label: 'Email', sortable: true, is_num: false },
    { column: 'loggedInAt', label: 'Последний вход', sortable: true, is_num: false },
    { column: 'isActive', label: 'Работает?', sortable: true, is_num: true, width: 10 },
    { column: 'view', label: 'Просмотр', sortable: false, is_num: false, width: 10 },
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
        id: 'promo',
        title: 'Промо-акции',
        icon: 'bi bi-server',
        items: [
            {
                route: 'Manager.Promo.Create',
                title: 'Новая промо-акция',
            },
            {
                route: 'Manager.Promo.Index',
                title: 'Мои промо-акции',
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

export const OPEN_WEATHER_BASE_URL = 'https://api.openweathermap.org/geo/1.0/direct';
export const OPEN_WEATHER_API_KEY = import.meta.env.VITE_OPEN_WEATHER_API_KEY;
export const DEFAULT_SURPLUS_PERCENT = 30;
export const TWO_WEEKS_AHEAD = new Date(new Date().getTime() + 12096e5);
export const FOUR_WEEKS_AHEAD = new Date(new Date().getTime() + 12096e5 * 2);
export const PRODUCT_IMG_PATH = '/assets/img/products/';
export const NO_PRODUCT_IMG = '/assets/img/no-image.png';
export const ALLOWED_FILE_TYPES = ['gif', 'jpeg', 'jpg', 'png'];
export const VAT_RATE = 1.2;
export const OFFICE_EXPENSES    = 0.075;
export const MARKETING_EXPENSES = 0.05;
