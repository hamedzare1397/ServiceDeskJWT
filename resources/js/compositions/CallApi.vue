<script>
import axios from "axios";
import {useAuthStore} from "../store/user.js";
import {ref} from "vue";

export function useApi(){
    const useAuth = useAuthStore();
    function post(url,data={},config={}){
        url = 'api/' + url;
        return axios.post(url, data, config);
    }

    function put(url,data={},config={}){
        url = 'api/' + url;
        return axios.put(url, data, config);
    }

    function get(url,config={}){
        if (url[url.length-1]==='&' || url[url.length-1]==='?')
            url = 'api/' + url + `token=${useAuth.getToken()}`;
        else
            url = 'api/' + url + `?token=${useAuth.getToken()}`;

        return axios.get(url, config);
    }
    function setAuthorization(token){
        axios.defaults.headers.common['Authorization'] = token;
    }

    return {
        setAuthorization, post, get
    }
}

export function usePost(url,sendData={},config={},loading={value:true}){
    const response = ref(null);
    const error = ref(null);
    const data = ref(null);

    axios.post(`api/${url}`, sendData)
        .then(response => response.value = response)
        .then(response => data.value = response.data)
        .catch(error => error.value = error)
        .finally(()=>{
            loading.value = false;
        })
    ;
    return {response, error, data};
}
export function usePut(url,sendData={}){
    const response = ref(null);
    const error = ref(null);
    const data = ref(null);

    axios.put(`api/${url}`, sendData)
        .then(response => response.value = response)
        .then(response => data.value = response.data)
        .catch(error => error.value = error)
    ;
    return {response, error, data};
}
</script>
