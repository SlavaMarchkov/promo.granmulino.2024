<template>
    <AdminHeader/>
    <Sidebar :menuItems="menuItems"/>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>{{ $route.meta.title }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <RouterLink :to="{ name: 'Admin.Index' }">Главная</RouterLink>
                    </li>
                    <li class="breadcrumb-item active">{{ $route.meta.title }}</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <RouterView></RouterView>
        </section>
    </main>
    <Footer/>
</template>

<script setup>
import AdminHeader from '@/components/AdminHeader.vue';
import Sidebar from '@/components/Sidebar.vue';
import Footer from '@/components/Footer.vue';

const menuItems = [
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
</script>
