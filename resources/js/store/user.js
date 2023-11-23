import {defineStore} from 'pinia'
import {inject, ref} from "vue";
import {useRouter} from "vue-router";

export const useUserStore = defineStore('user', () => {
    const router = useRouter();
    const authStore = useAuthStore();

    const information = ref({
        avatar:'',
    });
    const navigations = ref([]);
    function setInformation(info){
        information.value = info;
    }
    async function getNavigations(){
        try {
            let response = await axios.post('api/user/navigation');
            if (response.status == 200) {
                navigations.value = response.data;
            }
        }catch (ex)
        {
            authStore.setToken();
        }
    }
    async function getData()
    {
        try {
            let response = await axios.get('api/user/myInfo');
            information.value = response.data;
        }catch (err)
        {
            authStore.setToken();
        }
    }

    return {
        //functionsپ
        getData, setInformation,getNavigations,
        //variables
        information,navigations,
    };
});

export const useAuthStore = defineStore('user-auth', () => {
    const token = ref(null);
    const userStore = useUserStore();
    // const router = useRouter();

    function setToken(val)
    {
        token.value = val;
        axios.defaults.headers.authorization = `bearer ${val}`;
    }

    async function login(person){
        let response = await axios.post('/api/login', person);
        if (response.status == 200) {
            userStore.setInformation(response.data.user);
            setToken(response.data.authorisation.token);
            localStorage.setItem('token', response.data.authorisation.token);
            // debugger;
            router.push({name: 'dashboard'});
        }
        return true;
    }
    async function logout(){
        let response=await axios.post('/api/logout');
        if (response.status == 200 || response.status==401) {
            userStore.setInformation(null);
            setToken(null);
            localStorage.removeItem('token');
            router.push({name:'Login'});
        }
        return true;
    }

    return {
        //functions
        setToken, login, logout,
        //variables
        token
    };
});
export const useRegisterStore = defineStore('user-register', () => {

    return {
        //functions

        //variables

    }
});
