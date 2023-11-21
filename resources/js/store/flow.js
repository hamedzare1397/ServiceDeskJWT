import {defineStore} from 'pinia';

export const useFlowStore = defineStore('flow', () => {

    async function getFlowWithCode({code}){
        return await axios.post(`api/rq/tracking`,{trackCode:code});
    }

    return {
        getFlowWithCode,
    }
});
