export default {
    namespaced:true,
    state:{
        key:'',
        image:'',
    },
    mutations:{
        setCaptcha(state, data) {
            state.image = data.img;
            state.key= data.key;
        }
    },
    getters:{
        getCaptchaKey(state) {
            return state.key;
        },getCaptchaImage(state) {
            return state.image;
        },getCaptcha(state) {
            return {key:state.key, image: state.image};
        },
    },
    actions:{
        async reqCaptcha(context,app){
            await axios.post(addressAPI + '/captcha')
                .then(response => {
                    context.commit('setCaptcha', response.data);
                })
                .catch(errs => {
                    alert('خطا در ارتباط با سرور');
                });
        },
    }
}