<template>
    <AdminHeader/>
    <Sidebar :menuItems="ADMIN_MENU_ITEMS"/>
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
import AdminHeader from '@/components/layout/AdminHeader.vue';
import Sidebar from '@/components/layout/Sidebar.vue';
import Footer from '@/components/layout/Footer.vue';
import { ADMIN_MENU_ITEMS } from '@/helpers/constants.js';
</script>
