import {createRouter, createWebHashHistory} from 'vue-router';
// import ManagerModules from './managerRoutes'
// import CustomerModules from './customerRoutes'
import UserRoutes from './users/login.js'
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
            component: () => import('@/view/v1/Customer/App.vue'),
            children: UserRoutes,
        }

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
        return next({name:"Home"});
    }
    else if (tokenLogin.value && to.name==='Login'){
        return next(to);
    }
    else if (to.name==="Login"){
        next();
    }
    else{
        return next({name:"Login"})
    }
})
export default router;
