import Vue from 'vue';
import VueRouter from 'vue-router';
import store from '@/store';
import { LINK_ACTIVE_CLASS } from '@/config';
import routes from './routes';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    linkActiveClass: LINK_ACTIVE_CLASS || 'active',
    routes,
});

/* eslint-disable */
router.beforeEach((to, from, next) => {
    const user = store.getters['auth/user'];
    const authenticated = store.getters['auth/authenticated'];

    const authRequired = to.matched.some((route) => route.meta.auth);
    const guestRequired = to.matched.some((route) => route.meta.guest);
    const adminRequired = to.matched.some((route) => route.meta.admin);

    if (authRequired) {
        if (!authenticated) {
            next({ name: 'login' });
        } else {
            if (adminRequired && !user.is_admin) {
                next({ name: 'dashboard' });
            } else {
                next();
            }
        }
    } else if (guestRequired && authenticated) {
        next({ name: 'dashboard' });
    } else {
        next();
    }
});

export default router;
