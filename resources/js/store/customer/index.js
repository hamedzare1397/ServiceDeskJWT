import {defineStore} from "pinia";
import {ref} from 'vue';
export const useCustomerStore=defineStore('customerStore',() => {
    const person = ref({
        firstname: '',
        lastname: '',
        nativeid: '',
        mobile: '',
        captcha: '',
        captchaKey: ''
    })
    const stateRequest = ref(0);
    const successPercent = ref(10);
    const maxSuccessPercent = ref(100);
    const messages = ref({
        show: false,
        text: {},
        variant: 'danger'
    })

    function setStateNext() {
        stateRequest.value += 1;
    }

    function setStateRequest(dataState) {
        stateRequest.value = dataState;
    }

    function setSuccessPercent(val) {
        if (val <= maxSuccessPercent.value && val >= 0)
            successPercent.value = val;
    }

    function setMaxSuccessPercent(dataState) {
        maxSuccessPercent.value = dataState;
    }

    function setPerson(state, person) {
        person.value = person;
    }


    function setMessagesError({show, errors, variant}) {
        messages.value.text = errors;
        if (show != undefined || show != null)
            show = true;
        messages.value.show = show;
        messages.value.variant = variant;
    }



    function setMessagesShow(statusShow) {
        messages.value.show = statusShow;
    }

    function getMessagesError() {
        return messages.value
    }

    async function saveCustomer() {
        person.value.captchaKey = Captcha.key;
        await axios.post(addressAPI + '/rq/customer', context.person)
            .then(respond => {
                context.commit('setMessagesError', {show: false, errors: [], variant: 'success'});
                if (respond.data.api_token) {
                    window.axios.defaults.headers.common['Authorization'] = `Bearer ${respond.data.api_token}`;
                    context.commit('setStateNext');
                }
            })
            .catch(errs => {
                context.commit('setMessagesError', errs.response.data, true);
            })
            .finally(() => {
                this.dispatch('Captcha/reqCaptcha');
            })
        ;
    }


    return {
        saveCustomer,

        messages,maxSuccessPercent,person,successPercent,stateRequest,
    }
})
