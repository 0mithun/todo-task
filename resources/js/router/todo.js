const routes = [
    {
        path: '/todo',
        name: 'todo.index',
        component: ()=> import('@/pages/Todo/Index.vue'),
        meta: {title: 'Todo'}
    },
    {
        path: '/todo/create',
        name: 'todo.create',
        component: ()=> import('@/pages/Todo/Create.vue'),
        meta: {title: 'Create todo'}
    },
    {
        path: '/todo/edit/:id',
        name: 'todo.edit',
        component: ()=> import('@/pages/Todo/Edit.vue'),
        meta: {title: 'Edit todo'}
    },
]

export default routes;
