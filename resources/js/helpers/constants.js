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
        id: 'DISCOUNT',
        promoLabel: 'Скидка в цене',
        promoCode: 'ЖЦ',
        isForRetail: true,
    },
    {
        id: 'SALES_PEOPLE_BOOST',
        promoLabel: 'Мотивация торгового персонала',
        promoCode: 'МТП',
        isForRetail: false,
    },
    /*{
        id: 'GIFT_FOR_PURCHASE',
        promoLabel: 'Подарок за покупку',
        promoCode: 'ПП',
        isForRetail: true,
    },
    {
        id: 'RETAILERS_BOOST',
        promoLabel: 'Мотивация розничных точек',
        promoCode: 'МРТ',
        isForRetail: false,
    },
    {
        id: 'COVERAGE_INCREASE',
        promoLabel: 'Увеличение покрытия',
        promoCode: 'УП',
        isForRetail: false,
    },
    {
        id: 'IN_OUT',
        promoLabel: 'Временный ввод в матрицу сети In-Out',
        promoCode: 'IN-OUT',
        isForRetail: true,
    },*/
];

export const PROMO_STATUSES = [
    {
        id: 'ON_APPROVAL',
        name: 'На согласовании',
    },
    {
        id: 'IN_PROCESS',
        name: 'В работе',
    },
    {
        id: 'WAITING_FOR_REPORT',
        name: 'В ожидании отчета',
    },
    {
        id: 'DONE',
        name: 'Завершенные',
    },
    {
        id: 'DECLINED',
        name: 'Отклоненные',
    },
];

export const QUARTERS = [
    {
        id: 'q1',
        period: 'I квартал',
    },
    {
        id: 'q2',
        period: 'II квартал',
    },
    {
        id: 'q3',
        period: 'III квартал',
    },
    {
        id: 'q4',
        period: 'IV квартал',
    },
    {
        id: 'hy1',
        period: '1-е полугодие',
    },
    {
        id: 'hy2',
        period: '2-е полугодие',
    },
];

export const ROLES = {
    SUPER_ADMIN: 'SUPER_ADMIN',
    PRICE_ADMIN: 'PRICE_ADMIN',
    ADMIN: 'ADMIN',
    MANAGER: 'MANAGER',
};

export const ADMIN_ROLES = {
    SUPER_ADMIN: 'Супер-Администратор',
    PRICE_ADMIN: 'Прайс-Администратор',
    ADMIN: 'Администратор',
};

export const ADMIN_URLS = {
    ADMIN: '/admin/administrators',
    CATEGORY: '/admin/categories',
    CITY: '/admin/cities',
    CUSTOMER: '/admin/customers',
    PRODUCT: '/admin/products',
    PROMO: '/admin/promos',
    REGION: '/admin/regions',
    RETAILER: '/admin/retailers',
    SALES: '/admin/sales',
    USER: '/admin/users',
};

export const MANAGER_URLS = {
    CATEGORY: '/categories',
    CHANNEL: '/channels',
    CUSTOMER: '/customers',
    MARK: '/marks',
    PRODUCT: '/products',
    PROMO: '/promos',
    RETAILER: '/retailers',
    SALES: '/sales',
    SELLER: '/sellers',
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

export const ADMIN_TH_FIELDS = [
    { column: 'id', label: 'ID', sortable: true, is_num: true, width: 6 },
    { column: 'lastName', label: 'Фамилия', sortable: true, is_num: false },
    { column: 'firstName', label: 'Имя', sortable: true, is_num: false },
    { column: 'middleName', label: 'Отчество', sortable: true, is_num: false },
    { column: 'email', label: 'Email', sortable: true, is_num: false },
    { column: 'roleName', label: 'Роль', sortable: true, is_num: false },
    { column: 'loggedInAt', label: 'Последний вход', sortable: true, is_num: false },
    { column: 'isActive', label: 'Работает?', sortable: true, is_num: true, width: 8 },
    { column: 'view', label: 'Просмотр', sortable: false, is_num: false, width: 8 },
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
        isCollapsible: false,
        id: 'sales',
        route: 'Manager.Sales.Index',
        title: 'Мои продажи',
        icon: 'bi bi-cash-coin',
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
                title: 'Мои контрагенты',
            },
            {
                route: 'Manager.Retailer.Index',
                title: 'Мои торговые сети',
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
        isCollapsible: false,
        id: 'promo',
        route: 'Promo.Index',
        title: 'Промо-акции',
        icon: 'bi bi-megaphone-fill',
    },
    {
        isCollapsible: false,
        id: 'sales',
        route: 'Sales.Index',
        title: 'Продажи',
        icon: 'bi bi-cash-stack',
    },
    {
        isCollapsible: true,
        id: 'reports',
        title: 'Отчёты',
        icon: 'bi bi-graph-down',
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
            {
                route: 'Administrator.Index',
                title: 'Администраторы',
            },
        ],
    },
    {
        isCollapsible: false,
        id: 'notifications',
        route: 'Notification.Index',
        title: 'Уведомления',
        icon: 'bi bi-bell-fill',
    },
];

export const OPEN_WEATHER_BASE_URL = 'https://api.openweathermap.org/geo/1.0/direct';
export const OPEN_WEATHER_API_KEY = import.meta.env.VITE_OPEN_WEATHER_API_KEY;
export const TWO_WEEKS_AHEAD = new Date(new Date().getTime() + 12096e5);
export const FOUR_WEEKS_AHEAD = new Date(new Date().getTime() + 12096e5 * 2);
export const ALLOWED_FILE_TYPES = ['gif', 'jpeg', 'jpg', 'png'];
export const INITIALS = {
    MOTIVATION_FOR_SUPERVISORS: 5, // процент мотивации для супервайзеров
    MOTIVATION_FOR_SELLERS: 10, // процент мотивации для торговых представителей
    SURPLUS_PERCENT: 30, // дефолтный процент увеличения продаж для планов торговым представителям
    NET_PROFIT_THRESHOLD: 20, // порог в процентах для расчета норматива чистой прибыли
    MOTIVATION_THRESHOLD: 90, // порог в процентах для начисления мотивации (если не достигнут, то мотивация не начисляется)
    BASE_DISCOUNT: 20, // начальная скидка (%)
    BASE_TRANSPORT_RATE: 100_000, // начальная транспортная ставка (руб.)
    BASE_ORDER_WEIGHT: 16_000, // начальный вес заказа (кг)
    OFFICE_EXPENSES: 0.075, // расходы на офис 7.5%
    MARKETING_EXPENSES: 0.05, // расходы на маркетинг 5%
    VAT_RATE: 1.2, // НДС в размере 20% для расчета логистики
};
export const IMAGES = {
    USER_IMG_PATH: '/storage/images/user/', // путь к картинкам пользователя
    USER_IMG_TH_PATH: '/storage/images/user/thumbnails/',
    PRODUCT_IMG_PATH: '/storage/images/product/', // путь к картинкам продукта
    PRODUCT_IMG_TH_PATH: '/storage/images/product/thumbnails/',
    DEFAULT_IMG: '/assets/img/no-image.png', // путь к дефолтной картинке
};
