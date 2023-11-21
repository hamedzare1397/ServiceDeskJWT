import {defineStore} from 'pinia';

export const useFormStore=defineStore('form',()=>{
    function getTracking(code){
        console.log(code);
    }

    return {
        getTracking,

    }
})
