import { RouteConfig } from 'vue-router';

const Home = () => import('@/views/Home.vue');
const Dashboard = () => import('@/views/Dashboard.vue');
const Login = () => import('@/views/Login.vue');
const Error = () => import('@/views/Error.vue');
const NotFound = () => import('@/views/NotFound.vue');

// quizzes
const QuizzesBase = () => import('@/views/quizzes/Base.vue');
const QuizzesIndex = () => import('@/views/quizzes/Index.vue');
const CreateQuiz = () => import('@/views/quizzes/Create.vue');
const EditQuiz = () => import('@/views/quizzes/Edit.vue');

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
    // quizzes
    {
        path: '/quizzes',
        component: QuizzesBase,
        meta: {
            auth: true,
        },
        children: [
            {
                path: '',
                name: 'quizzes',
                component: QuizzesIndex,
                meta: {
                    auth: true,
                },
            },
            {
                path: 'create',
                name: 'quizzes.create',
                component: CreateQuiz,
                meta: {
                    auth: true,
                },
            },
            {
                path: ':id/edit',
                name: 'quizzes.edit',
                component: EditQuiz,
                meta: {
                    auth: true,
                },
            },
        ],
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
