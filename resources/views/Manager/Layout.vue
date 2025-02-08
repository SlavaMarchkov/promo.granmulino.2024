<template>
    <ManagerHeader/>
    <Sidebar :menuItems="MANAGER_MENU_ITEMS"/>
    <main id="main" class="main">
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
