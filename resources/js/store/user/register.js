import axios from 'axios'
export default {
    namespaced:true,
    state:{
        errorsRegister:{},
        successRegister:{},
        titleResult:'',
        person:{
            id:0
        }
    },
    mutations: {
        setErrorRegister(state, {data}) {
            state.errorsRegister = data.errors;
            state.successRegister='';
        },
        setSuccessRegister(state, data) {
            state.successRegister=data;
            state.person=data;
            state.errorsRegister = '';
        },
        setTitleResult(state, title) {
            state.titleResult = title;
        },
        setPerson(state, person) {
            state.person=person;
        }
    },
    getters:{
        getTitleResult(state){
            return state.titleResult;
        },
        getErrorRegister(state) {
            return state.errorsRegister;
        },
        getSuccessRegister(state) {
            return state.successRegister;
        },
    },
    actions:{
        registerUser(context, app) {
            app.$data.sending=true;
            axios.post(addressAPI + '/register', app.person)
                .then(response=>{
                    context.commit('setTitleResult', 'ثبت نام با موفقیت انجام شد.');
                    context.commit('setSuccessRegister', response.data);
                    //app.$bvModal.show('showResultRegister');
                    app.$data.sending=false;
                })
        .catch(err=>{
            context.commit('setTitleResult', 'خطا در ثبت نام');
            context.commit('setErrorRegister', err.response);
           // app.$bvModal.show('showResultRegister');
            app.$data.sending=false;
                });
        },
        verifyUser(context, app) {
            axios.post(addressAPI + '/verify',
                {
                    confirmationCode:app.confirmationCode,
                    person:context.state.person.id,
                }
                )
                .then(response => {
                    if (response.data.verifyCode === app.confirmationCode) {
                        //app.$bvModal.hide('showResultRegister');
                        app.$router.push('/peaple/login');
                    }
                })
                .catch(err => {
                    console.log(err.response.data);
                });
            console.log(app);
        }

    }
}
