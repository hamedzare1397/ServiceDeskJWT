export default [
    {
        path:'',
        name:'app.index',
        children:[
            {
                path:'setting',
                name:'app.setting',
                component: () => import('@/js/view/v1/setting/index.vye'),
            },
        ]
    },
    {
        path:'dashboard',
        name:'dashboard',
        component:()=>import('../../view/v1/Dashboard/index.vue'),
        meta:{}
    },

]
