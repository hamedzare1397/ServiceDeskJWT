export default {
    namespaced:true,
    state:{
        tracks:[],
        perpage:10,
        current_page:1,
        last_page:1,
        from:1,
        to:1,
        total:0
    },
    mutations:{
        setTracks(state, data) {
            state.tracks = data;
        },
        setTotal(state, data) {
            state.total= data;
        },
        setCurrentPage(state, data) {
            state.current_page= data;
        },
        setLastPage(state,data){
            state.last_page=data;
        },
        setFrom(state,data){
            state.from=data;
        },
        setTo(state,data) {
            state.to = data;
        },
    },
    getters: {
        getTracks(state) {
            return state.tracks;
        },
        getCurrentPage(state) {
            return state.current_page;
        },
        getLastPage(state){
            return state.last_page;
        },
        getFrom(state){
            return state.from;
        },
        getTo(state){
            return state.to;
        },
    },
    actions:{
        async reqTracks(context,{page,isNotSend,search}) {
            let url = window.addressAPI + '/track';
            if (page || search || isNotSend) {
                url += '?'
                if (page != undefined) {
                }
                url += 'page=' + page;
                if (search != undefined && search!='') url += `&search=${search}`;
                if (isNotSend && isNotSend != undefined) url += '&isNotSend=' + isNotSend;
            }
            await axios.get(url)
                .then(response=>{
                    if (response.data != undefined) {
                        context.commit('setTracks', response.data.data);
                        context.commit('setCurrentPage', response.data.current_page);
                        context.commit('setFrom', response.data.from);
                        context.commit('setTo', response.data.to);
                        context.commit('setLastPage', response.data.last_page);
                        context.commit('setTotal', response.data.total);
                    }
                    return {result: 'success'}
                })
                .catch(errs=>{
                    if(errs.response!=undefined)
                        return {result: 'fails', errors: errs.response};
                    else
                        return {result:'fails', errors:errs}

                }).finally(()=>{

                })
            ;
        },
        async reqSendToFarzin(context, track) {
            let res=null;
                await axios.post(window.addressAPI+'/track/send/'+track.id)
                .then(response=>{
                    res=response.data
                })
                .catch(errs=>{

                })
            ;
            return res;
        }
    }
}
