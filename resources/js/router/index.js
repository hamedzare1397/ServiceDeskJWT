import {createRouter, createWebHashHistory} from 'vue-router';

import AppRoutes from './App/application.js'
import {useAuthStore, useUserStore} from "@/store/user.js";
import {computed} from "vue";


const router=createRouter({
    history:createWebHashHistory(),
    routes:[
        {
            path:'',
            component: () => import('@/view/v1/login/index.vue'),
            name:'Login',
            meta:{
                title:'ورود به سیستم'
            }
        },
        {
            path: '/app',
            name:'App',
            component: () => import('@/view/v1/App.vue'),
            children: AppRoutes,
        },
        {
            path:'/:subpath',
            redirect:'/app',
        },

    ]
});
router.beforeEach(async (to,from,next)=>{
    const authStore = useAuthStore();
    const userStore = useUserStore();
    const tokenLogin = computed(() => authStore.token);

    if(!tokenLogin.value ){
        let token=localStorage.getItem("token");
        if (token){
            await authStore.setToken(token);
            await userStore.getData();
        }
    }
    if (to.name!=="Login")
    {
        if(tokenLogin.value)
        {
            next()
        }
        else{
            return next({name: "Login"});
        }
    }
    else if (tokenLogin.value && to.name==='Login')
    {
        return next({name:"App.Dashboard"});
    }
    else if (!tokenLogin.value && to.name==="Login"){
        next();
    }
    else{
        return next({name:"Login"})
    }
})
export default router;
