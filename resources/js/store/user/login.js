import {defineStore} from "pinia";
import axios from "axios";
import {inject, ref} from "vue";
import {useRouter} from "vue-router";

export const useLoginStore = defineStore('userLogin', () => {
    const addressAPI = inject('config').addressApi;
    const messagesLogin = ref({});
    const {push} = useRouter();

    function setMessages({data}) {
        messagesLogin.value = data.errors;
    }

    function getMessagesLogin() {
        return messagesLogin.value;
    }

    async function loginToWeb(app) {
        let response = await axios.post(addressAPI+'/login', app.person);
        let token = response.data.api_token;
        if (token) {
            localStorage.setItem('token', token);
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
            window.axios.defaults.headers.common['Accept'] = 'application/json';
            push({name: 'listForm'})
        } else {
            console.error('Authorization token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
        }
    }

    function logout(app) {
        try {
            localStorage.clear();
            delete window.axios.defaults.headers.common['Authorization'];
            push('/');
        } catch (e) {
            localStorage.clear();
            delete window.axios.defaults.headers.common['Authorization'];
            location.reload()
        }
    }

    return {
        //functions
        loginToWeb, getMessagesLogin,  logout, setMessages,

        //const
        messagesLogin,
    }
});
