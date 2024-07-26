<template>
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <template v-for="menuItem in menuItems" :key="menuItem.id">
                <li v-if="menuItem.isCollapsible" class="nav-item">
                    <a class="nav-link collapsed" href="#" @click="collapse(menuItem.id)">
                        <i :class="menuItem.icon"></i><span>{{ menuItem.title }}</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul :id="menuItem.id" class="nav-content collapse" data-bs-parent="#sidebar-nav" style="">
                        <li v-for="item in menuItem.items">
                            <RouterLink :to="{ name: item.route }">
                                <i class="bi bi-circle"></i><span>{{ item.title }}</span>
                            </RouterLink>
                        </li>
                    </ul>
                </li>
                <li v-else class="nav-item">
                    <RouterLink
                        @click="closeOpenedMenuItems"
                        :id="menuItem.id"
                        :class="$route.name === menuItem.route
                            ? 'nav-link'
                            : 'nav-link collapsed'"
                        :to="{ name: menuItem.route }"
                    >
                        <i :class="menuItem.icon"></i>
                        <span>{{ menuItem.title }}</span>
                    </RouterLink>
                </li>
            </template>
        </ul>
    </aside>
</template>

<script setup>
const menuItems = [
    {
        isCollapsible: false,
        id: 'dashboard',
        route: 'Dashboard',
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

const collapse = (element) => {
    const collapseElementList = document.querySelectorAll('.collapse');
    collapseElementList.forEach(el => {
        const collapsedElement = el.previousElementSibling;
        if ( el.id === element ) {
            el.classList.toggle('show');
            collapsedElement.classList.toggle('collapsed');
        } else {
            el.classList.remove('show');
            collapsedElement.classList.add('collapsed');
        }
    });
};

const closeOpenedMenuItems = () => {
    const collapseElementList = document.querySelectorAll('.collapse');
    collapseElementList.forEach(el => {
        const collapsedElement = el.previousElementSibling;
        el.classList.remove('show');
        collapsedElement.classList.add('collapsed');
    });
};
</script>
