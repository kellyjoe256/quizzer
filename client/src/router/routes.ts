import { RouteConfig } from 'vue-router';

const Home = () => import('@/views/Home.vue');
const Dashboard = () => import('@/views/Dashboard.vue');
const Login = () => import('@/views/Login.vue');
const Error = () => import('@/views/Error.vue');
const NotFound = () => import('@/views/NotFound.vue');

const routes: RouteConfig[] = [
    {
        path: '/',
        name: 'home',
        component: Home,
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: {
            auth: true,
        },
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            guest: true,
        },
    },
    {
        path: '/error',
        name: 'error',
        component: Error,
    },
    {
        path: '*',
        name: 'not-found',
        component: NotFound,
    },
];

export default routes;
