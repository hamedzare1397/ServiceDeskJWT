import {defineStore} from 'pinia'
import {inject, ref} from "vue";
import router from '../router';
import {useApi} from '../compositions/CallApi.vue'

export const useUserStore = defineStore('user', () => {
    const authStore = useAuthStore();
    const api = useApi();

    const information = ref({
        avatar:'',
    });
    const navigations = ref([]);
    function setInformation(info){
        information.value = info;
    }
    async function getNavigations(){
        try {
            let response = await api.post('navigation');
            if (response.status == 200) {
                navigations.value = response.data;
            }
        }catch (ex)
        {

        }
    }
    async function getData()
    {
        try {
            let response = await api.post('information');
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
    const api = useApi();
    const token = ref(null);
    const userStore = useUserStore();
    // const router = useRouter();

    function setToken(val)
    {
        token.value = val;
        api.setAuthorization(`bearer ${val}`);
    }
    function getToken() {
        return token.value;
    }
    async function login(person) {
        let response =null;
        try{
            response=await api.post('login', person);
            if (response.status == 200) {
                userStore.setInformation(response.data.user);
                setToken(response.data.authorisation.token);
                localStorage.setItem('token', response.data.authorisation.token);
                return response;
            }
        }
        catch(errors){
            return Promise.reject(errors)
        }
    }
    async function logout(){
        let response=await api.post('logout');
        if (response.status == 200 || response.status==401) {
            userStore.setInformation(null);
            setToken(null);
            localStorage.removeItem('token');
        }
        return true;
    }

    return {
        //functions
        setToken, getToken, login, logout,
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
