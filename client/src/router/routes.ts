import { RouteConfig } from 'vue-router';

const Home = () => import('@/views/Home.vue');
const TakeQuiz = () => import('@/views/quizzer/Index.vue');
const Dashboard = () => import('@/views/Dashboard.vue');
const Login = () => import('@/views/Login.vue');
const Error = () => import('@/views/Error.vue');
const NotFound = () => import('@/views/NotFound.vue');

// quizzes
const QuizzesBase = () => import('@/views/quizzes/Base.vue');
const QuizzesIndex = () => import('@/views/quizzes/Index.vue');
const CreateQuiz = () => import('@/views/quizzes/Create.vue');
const EditQuiz = () => import('@/views/quizzes/Edit.vue');

// questions
const QuestionsBase = () => import('@/views/questions/Base.vue');
const QuestionsIndex = () => import('@/views/questions/Index.vue');
const CreateQuestion = () => import('@/views/questions/Create.vue');
const EditQuestion = () => import('@/views/questions/Edit.vue');

// answers
const AnswersBase = () => import('@/views/answers/Base.vue');
const AnswersIndex = () => import('@/views/answers/Index.vue');
const CreateAnswer = () => import('@/views/answers/Create.vue');
const EditAnswer = () => import('@/views/answers/Edit.vue');

// users
const UsersBase = () => import('@/views/users/Base.vue');
const UsersIndex = () => import('@/views/users/Index.vue');
const CreateUser = () => import('@/views/users/Create.vue');
const EditUser = () => import('@/views/users/Edit.vue');

const routes: RouteConfig[] = [
    {
        path: '/',
        name: 'home',
        component: Home,
    },
    {
        path: '/:id/take_quiz',
        name: 'take_quiz',
        component: TakeQuiz,
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
    // questions
    {
        path: '/questions',
        component: QuestionsBase,
        meta: {
            auth: true,
        },
        children: [
            {
                path: '',
                name: 'questions',
                component: QuestionsIndex,
                meta: {
                    auth: true,
                },
            },
            {
                path: 'create',
                name: 'questions.create',
                component: CreateQuestion,
                meta: {
                    auth: true,
                },
            },
            {
                path: ':id/edit',
                name: 'questions.edit',
                component: EditQuestion,
                meta: {
                    auth: true,
                },
            },
        ],
    },
    // answers
    {
        path: '/answers',
        component: AnswersBase,
        meta: {
            auth: true,
        },
        children: [
            {
                path: '',
                name: 'answers',
                component: AnswersIndex,
                meta: {
                    auth: true,
                },
            },
            {
                path: 'create',
                name: 'answers.create',
                component: CreateAnswer,
                meta: {
                    auth: true,
                },
            },
            {
                path: ':id/edit',
                name: 'answers.edit',
                component: EditAnswer,
                meta: {
                    auth: true,
                },
            },
        ],
    },
    // users
    {
        path: '/users',
        component: UsersBase,
        meta: {
            auth: true,
            admin: true,
        },
        children: [
            {
                path: '',
                name: 'users',
                component: UsersIndex,
                meta: {
                    auth: true,
                    admin: true,
                },
            },
            {
                path: 'create',
                name: 'users.create',
                component: CreateUser,
                meta: {
                    auth: true,
                    admin: true,
                },
            },
            {
                path: ':id/edit',
                name: 'users.edit',
                component: EditUser,
                meta: {
                    auth: true,
                    admin: true,
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
