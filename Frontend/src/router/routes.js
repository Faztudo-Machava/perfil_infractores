const routes = [{
        path: '/',
        component: () =>
            import ('layouts/Layout.vue'),
        children: [{
                path: '',
                component: () =>
                    import ('pages/Login.vue')
            },
            {
                path: '/Registar',
                component: () =>
                    import ('pages/Registar.vue')
            }
        ]
    },
    {
        path: '/perfil',
        component: () =>
            import ('layouts/userLayout.vue'),
        children: [{
                path: '',
                component: () =>
                    import ('pages/Perfil.vue')
            },
            {
                path: '/regra',
                component: () =>
                    import ('pages/Regra.vue')
            }
        ]
    },
    // Always leave this as last one,
    // but you can also remove it
    {
        path: '/:catchAll(.*)*',
        component: () =>
            import ('pages/Error404.vue')
    }
]

export default routes