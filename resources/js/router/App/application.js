export default [
    {
        path:'',
        name:'App.Index',
        children:[
            {
                path:'setting',
                name:'App.Setting',
                component: () => import('@/view/v1/setting/index.vue'),
                children:[
                    {
                        path:'users',
                        name:'App.Setting.User',
                        component: () => import('@/view/v1/setting/user/index.vue')
                    },
                    {
                        path:'oastn',
                        name:'App.Setting.Ostan',
                        component: () => import('@/view/v1/setting/ostan/index.vue')
                    }

                ]
            },
        ]
    },
    {
        path:'dashboard',
        name:'App.Dashboard',
        component:()=>import('../../view/v1/Dashboard/index.vue'),
        meta:{}
    },

]
