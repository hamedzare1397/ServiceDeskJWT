import axios from 'axios'
import {useAppStore} from "../store";
import router from '../router/index.js';

// axios.defaults.withCredentials = true;
// console.log(import.meta.env.VITE_API_URL);
axios.defaults.baseURL = import.meta.env.VITE_API_URL;
axios.interceptors.response.use((response)=>{
    return response;
},async (error) => {
    const appStore = useAppStore();
    switch (error.response.status)
    {
        case 401:
            if (error.response.data.username!=undefined)
            {
            }
            else {
                localStorage.removeItem('token');
                router.push({name: 'Login'});
            }
            break;
        case 403:
            alert('شما مجوز دسترسی به این بخش را ندارید.')
            break;
    }
    return Promise.reject(error);
})
