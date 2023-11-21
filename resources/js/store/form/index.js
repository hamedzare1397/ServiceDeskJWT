export default {
    namespaced: true,
    state: {
        forms:{},
        selectForm:{},
        errs:{}
    },
    mutations: {
        setForms(state, data) {
            state.forms=data;
        },
        setForm(state, data) {
            state.selectForm=data;
        },
        setErrors(state, data) {
            state.errs=data;
        },
    },
    getters: {

        getForms(state) {
            return state.forms;
        },

        getForm(state) {
            return state.selectForm;
        },

        getErrors(state) {
            return state.errs;
        }
    },
    actions: {
        /**
         * formCreate
         * @param context
         * @param app
         */
        storeForm(context, app) {
            let sendData = _.assign({}, app.form);
            sendData.fields = sendData.fields.map(record => {
                record.dataField = JSON.stringify(record.dataField);
                return record;
            });
            app.errs={};
            app.messages={};
            axios.post(addressAPI + '/form', app.form)
                .then(respond => {
                    app.messages = respond.data;
                    app.$bvModal.show('showResult');
                })
                .catch(errs=>{
                app.errs = errs.response.data;
                app.$bvModal.show('showResult')
                });
        },
        async updateForm(context,dataSend) {
            dataSend.append('_method', 'PUT');
            await axios.post( addressAPI + '/form/'+dataSend.get('formID'), dataSend)
                .then(response => {
                    console.log(response.data);
                    return response;
                })
                .catch(errs=>{
                    throw errs;
                });

        },
        /**
         * Request For get List forms
         * @param context
         * @param app
         */
        reqForms(context, app) {
            context.commit('setErrors', {});
            app.isSendRequest=true;
            axios.get(addressAPI + '/form')
                .then(respond => {
                    context.commit('setForms',respond.data)
                })
                .catch(errs => {
                    context.commit('setErrors', errs.response.data);
                    app.$bvModal.show('showResult');
                }).finally(()=>{
                app.isSendRequest = false;
            });
        },
        /**
         *
         * @param context
         * @param ژapp
         */
        reqForm(context, app) {
            if (app.selectedForm!=-1 && app.selectedForm!=undefined) {
                axios.get(addressAPI + "/form/" + app.selectedForm)
                    .then(respond => {
                        context.commit('setForm', respond.data);
                        if(app.modal!=undefined) {
                            app.modal.header = 'مشاهده';
                            app.modal.message = respond.data;
                            app.modal.variant = "success";
                            app.$bvModal.show('showResult');
                        }
                    })
                    .catch(errs => {
                        if (errs.response!=undefined)
                        context.commit('setErrs', errs.response.data);
                    })
                    .finally(() => {
                        app.selectedForm = -1;
                    })
                ;
            }

        }
    }
};
