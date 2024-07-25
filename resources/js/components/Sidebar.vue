<template>
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item" v-for="item in menuItems" :key="item.route">
                <RouterLink
                    class="nav-link"
                    :to="{ name: item.route }"
                >
                    <i :class=item.icon></i>
                    <span>{{ item.title }}</span>
                </RouterLink>
            </li>
        </ul>
    </aside>
</template>

<script setup>
const menuItems = [
    {
        route: 'Dashboard',
        title: 'Главная страница',
        icon: 'bi bi-speedometer',
    },
    /*{
        route: 'Customer.Index',
        title: 'Контрагенты',
        icon: 'bi bi-people-fill',
    },
    {
        route: 'Service.Index',
        title: 'Услуги',
        icon: 'bi bi-stack'
    },*/
];
</script>
