
// import Login from '../pages/Auth/Login.vue'

const routes = [
    {
        path: '/login',
        name: 'login',
        component: ()=>import('../pages/Auth/Login.vue'),
        meta: { middleware: 'guest', 'title': 'Login' }
    },
    {
        path: '/register',
        name: 'register',
        component: ()=>import('../pages/Auth/Register.vue'),
        meta: { middleware: 'guest', 'title': 'Register' }
    },
    // {
    //     path: '/forget-password',
    //     name: 'forget-password',
    //     component: () => import('../pages/Auth/ForgotPassword.vue'),
    //     meta: {
    //         middleware: 'guest',
    //         'title': 'Forgot Password'
    //     }
    // },
    // {
    //     path: '/reset-password',
    //     name: 'reset-password-form',
    //     component: () => import('../pages/Auth/ResetPassword.vue'),
    //     meta: {
    //         middleware: 'guest',
    //         'title': 'Reset password'
    //     }
    // },
]

export default routes;
