import { createRouter, createWebHistory } from 'vue-router'
import beforeEach from './beforeEach';
import auth from './auth'
import DashboardLayout from '../layouts/DashboardLayout.vue'
import dashboard from './dashboard'


const routes = [
    ...auth,
    {
        path: '/',
        component: DashboardLayout,
        meta: { middleware: "auth" },
        children: [
            {
                path: "/",
                redirect: 'dashboard',
            },
            ...dashboard,
        ]

    },
    {
        path: '/403',
        name: '403',
        component: () => import('./../pages/403.vue'),
        meta: {
            // middleware: 'guest',
            'title': 'Invalid access'
        }
    },
    {
        path: '/404',
        name: '404',
        component: () => import('./../pages/404.vue'),
        meta: {
            // middleware: 'guest',
            'title': 'Not found'
        }
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: "/404",
    }
];

const router = createRouter({
    routes,
    history: createWebHistory()
});

router.beforeEach(beforeEach)

export default router;


