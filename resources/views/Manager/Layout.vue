<template>
    <ManagerHeader/>
    <Sidebar :menuItems="menuItems"/>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>{{ $route.meta.title }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <RouterLink :to="{ name: 'Manager.Index' }">Главная</RouterLink>
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
import ManagerHeader from '@/components/ManagerHeader.vue';
import Sidebar from '@/components/Sidebar.vue';
import Footer from '@/components/Footer.vue';

const menuItems = [
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
                route: 'Manager.Customer',
                title: 'Контрагенты',
            },
            {
                route: 'Manager.Retailer',
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
                route: 'Manager.Profile',
                title: 'Мой профиль',
            },
        ],
    },
];
</script>
