export default [
    {
        path:'dashboard',
        name:'dashboard',
        component:()=>import('../../view/v1/Customer/Dashboard/index.vue'),
        meta:{}
    },
    {
        path:'cartable',
        name:'cartable',
        children:[
            {
                path:'export',
                name:'cartable.export',
                component: () => import('../../view/v1/Customer/Cartable/Export/export.vue'),
            },
            {
                path:'import',
                name:'cartable.import',
                component: () => import('../../view/v1/Customer/Cartable/Import/import.vue'),
            },
        ]
    }

]
