<template>
    <AdminHeader/>
    <Sidebar :menuItems="ADMIN_MENU_ITEMS"/>
    <main id="main" class="main">
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
