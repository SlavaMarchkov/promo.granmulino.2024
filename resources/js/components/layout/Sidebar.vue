<template>
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <template v-for="menuItem in menuItems" :key="menuItem.id">
                <li v-if="menuItem.isCollapsible" class="nav-item">
                    <a class="nav-link collapsed" href="#" @click="collapse(menuItem.id)">
                        <i :class="menuItem.icon"></i><span>{{ menuItem.title }}</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                    </a>
                    <ul
                        :id="menuItem.id"
                        class="nav-content collapse"
                        data-bs-parent="#sidebar-nav"
                    >
                        <li v-for="item in menuItem.items">
                            <RouterLink
                                :to="{ name: item.route }"
                                :id="item.route"
                                active-class="active"
                            >
                                <i class="bi bi-circle"></i><span>{{ item.title }}</span>
                            </RouterLink>
                        </li>
                    </ul>
                </li>
                <li v-else class="nav-item">
                    <RouterLink
                        @click="closeOpenedMenuItems"
                        :id="menuItem.id"
                        :class="$route.name === menuItem.route
                            ? 'nav-link'
                            : 'nav-link collapsed'"
                        :to="{ name: menuItem.route }"
                        active-class="active"
                    >
                        <i :class="menuItem.icon"></i>
                        <span>{{ menuItem.title }}</span>
                    </RouterLink>
                </li>
            </template>
        </ul>
    </aside>
</template>

<script setup>
import { onMounted, onUpdated } from 'vue';
import { useDOMHandlers } from '@/use/useDOMHandlers.js';

const { closeOpenedMenuItems, openActiveRouteMenuItem, collapse } = useDOMHandlers();

defineProps({
    menuItems: {
        type: Array,
        default: [],
        required: true,
    },
});

onMounted(() => {
    openActiveRouteMenuItem();
});

// TODO
onUpdated(() => {
    //openActiveRouteMenuItem();
});
</script>
