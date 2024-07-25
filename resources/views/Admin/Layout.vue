<template>
    <Header/>
    <Sidebar/>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>{{ $route.meta.title }}</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <RouterLink :to="{ name: 'Dashboard' }">Главная</RouterLink>
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
import Header from '@/components/Header.vue';
import Sidebar from '@/components/Sidebar.vue';
import Footer from '@/components/Footer.vue';
</script>
