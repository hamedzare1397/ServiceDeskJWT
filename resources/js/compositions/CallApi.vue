<script>
import axios from "axios";
import {useAuthStore} from "../store/user.js";

export function useApi(){
    const useAuth = useAuthStore();
    function post(url,data={},config={}){
        url = 'api/' + url;
        return axios.post(url, data, config);
    }

    function get(url,config={}){
        url = 'api/' + url + `?token=${useAuth.getToken()}`;
        debugger;
        return axios.post(url, data, config);
    }
    function setAuthorization(token){
        axios.defaults.headers.common['Authorization'] = token;
    }

    return {
        setAuthorization, post, get
    }
}
</script>
