import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '@/stores/auth.js';
import { useAlertStore } from '@/stores/alerts.js';
import adminRoutes from '@/router/admin.routes.js';
import authRoutes from '@/router/auth.routes.js';
import adminAuthRoutes from '@/router/adminAuth.routes.js';
import managerRoutes from '@/router/manager.routes.js';

const routes = [
    { ...authRoutes },
    { ...adminAuthRoutes },
    { ...adminRoutes },
    { ...managerRoutes },
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

    const { title } = to.meta;
    document.title = `${brand} ${title ? ' :: ' + title : ''}`;

    const { getToken: authToken } = useAuthStore();
    const isAdmin = localStorage.getItem('user')
        ? JSON.parse(localStorage.getItem('user')).isAdmin
        : false;

    if ( to.meta.requiresAuth && to.meta.adminAuth && !authToken ) {
        next({ name: 'AdminLogin' });
    } else if ( to.meta.requiresAuth && to.meta.managerAuth && !authToken ) {
        next({ name: 'Login' });
    } else if ( to.meta.requiresGuest && authToken && isAdmin ) {
        next({ name: 'Admin.Index' });
    } else if ( to.meta.requiresGuest && authToken && !isAdmin ) {
        next({ name: 'Manager.Index' });
    } else {
        next();
    }
});

export default router;
