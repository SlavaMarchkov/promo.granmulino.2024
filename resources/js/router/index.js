import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '@/stores/auth.js';
import { useAlertStore } from '@/stores/alerts.js';
import adminRoutes from '@/router/admin.routes.js';
import authRoutes from '@/router/auth.routes.js';

const routes = [
    { ...authRoutes },
    { ...adminRoutes },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/',
    },
];

const router = createRouter({
    history: createWebHistory(),
    linkExactActiveClass: 'active',
    routes,
});

router.beforeEach((to, from, next) => {
    const alertStore = useAlertStore();
    alertStore.clear();

    const { getToken: authToken } = useAuthStore();

    const { title } = to.meta;
    document.title = `${brand} ${title ? ' :: ' + title : ''}`;

    if ( to.meta.requiresAuth && !authToken ) {
        next({ name: 'Login' });
    } else if ( to.meta.requiresGuest && authToken ) {
        next({ name: 'Dashboard' });
    } else {
        next();
    }
});

export default router;
