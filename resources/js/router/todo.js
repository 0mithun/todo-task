const routes = [
    {
        path: '/todo',
        name: 'todo.index',
        component: ()=> import('@/pages/Todo/Index.vue'),
        meta: {title: 'To-do'}
    }
]

export default routes;
