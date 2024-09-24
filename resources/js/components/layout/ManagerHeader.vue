<template>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <RouterLink
                @click="closeOpenedMenuItems"
                :to="{ name: 'Manager.Index' }"
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
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="/assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ user.fullName }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6>{{ user.lastName }} {{ user.firstName }} {{ user.middleName }}</h6>
                            <span>{{ user.email }}</span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <RouterLink
                                :to="{ name: 'Manager.Profile.Index' }"
                                class="dropdown-item d-flex align-items-center"
                            >
                                <i class="bi bi-person"></i>
                                <span>Мой профиль</span>
                            </RouterLink>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <div class="dropdown-item d-flex align-items-center">
                                <i class="bi bi-person-badge"></i>
                                <span>{{ user.roleName }}</span>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a
                                @click="handleLogout"
                                class="dropdown-item d-flex align-items-center"
                                href="#"
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
import { useRouter } from 'vue-router';
import { useDOMHandlers } from '@/use/useDOMHandlers.js';

const authStore = useAuthStore();
const router = useRouter();
const { closeOpenedMenuItems, toggleSidebar } = useDOMHandlers();

const props = {
    brand,
};

const { user } = authStore;

const handleLogout = async () => {
    if ( confirm('Вы действительно хотите выйти?') ) {
        const { status } = await authStore.logout();
        if (status && status === 'success') {
            await router.push({
                name: 'Login'
            });
        }
    }
};
</script>
