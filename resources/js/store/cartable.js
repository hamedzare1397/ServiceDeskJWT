import {defineStore} from 'pinia'
import {inject, ref} from "vue";

export const useCartableStore = defineStore('cartable', () => {
    const ApiAddress= inject('config').addressApi

    async function getList(type){
        try {
            let response = await axios.get(`${ApiAddress}/cartable/${type}`);
            return response;
        }catch (exception){
            return exception.errors;
        }
    }
    async function getFlowWithCode(code){
        try {
            let response = await axios.get(`${ApiAddress}/cartable/trackWithCode/${code}`);
            return response;
        }catch (exception){
            return exception.errors;
        }
    }
    return {
        //functions
        getList,getFlowWithCode,
        //variables
    }
});
