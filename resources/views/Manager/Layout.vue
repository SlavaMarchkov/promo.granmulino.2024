<template>
    <ManagerHeader/>
    <Sidebar :menuItems="MANAGER_MENU_ITEMS"/>
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
import ManagerHeader from '@/components/layout/ManagerHeader.vue';
import Sidebar from '@/components/layout/Sidebar.vue';
import Footer from '@/components/layout/Footer.vue';
import { MANAGER_MENU_ITEMS } from '@/helpers/constants.js';
</script>
