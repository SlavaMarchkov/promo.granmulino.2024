<template>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <RouterLink
                @click="closeOpenedMenuItems"
                :to="{ name: 'Admin.Index' }"
                class="logo d-flex align-items-center"
            >
                <img alt="" src="/assets/img/logo.png">
                <span class="d-none d-lg-block">{{ props.brand }}</span>
            </RouterLink>
            <i class="bi bi-list toggle-sidebar-btn" @click="toggleSidebar"></i>
        </div>
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" data-bs-toggle="dropdown" href="#">
                        <img alt="Profile" class="rounded-circle" src="/assets/img/profile-img.jpg">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ user.name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ user.name }}</h6>
                            <span>{{ user.email }}</span>
                        </li>
<!--                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <i class="bi bi-person"></i>
                                <span>Мой профиль</span>
                            </a>
                        </li>-->
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a
                                class="dropdown-item d-flex align-items-center"
                                href="#"
                                @click="handleAdminLogout"
                            >
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Выйти</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
</template>

<script setup>
import { useAuthStore } from '@/stores/auth.js';
import { useDOMHandlers } from '@/use/useDOMHandlers.js';

const authStore = useAuthStore();
const { closeOpenedMenuItems, toggleSidebar } = useDOMHandlers();

const props = {
    brand,
};

const user = authStore.getUser;

const handleAdminLogout = async () => {
    if ( confirm('Вы действительно хотите выйти?') ) {
        await authStore.adminLogout();
    }
};
</script>
