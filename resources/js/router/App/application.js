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
                        path:'ostan',
                        name:'App.Setting.Ostan',
                        component: () => import('@/view/v1/setting/ostan/index.vue')
                    },
                    {
                        path:'news',
                        name:'App.Setting.News',
                        component: () => import('@/view/v1/setting/news/index.vue')
                    },
                    {
                        path:'coefficient',
                        name:'App.Setting.Coefficient',
                        component: () => import('@/view/v1/setting/coefficient/index.vue')
                    },
                    {
                        path:'register',
                        name:'App.Setting.Register',
                        component: () => import('@/view/v1/setting/registerVal/index.vue')
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
    {
        path:'change-password',
        name:'App.ChangePassword',
        component:()=>import('../../view/v1/setting/user/components/changePassword.vue'),
        meta:{}
    },
    {
        path:'/about-me',
        name:'App.AboutMe',
        component:()=>import('../../view/v1/pages/aboutme.vue'),
    },
    {
        path:'/:subpath',
        redirect:{name:'App.Dashboard'},
    },

]
