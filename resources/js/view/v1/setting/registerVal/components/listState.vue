<template>
    <template v-for="(state,index) in states">
        <item-state :year-month="yearMonth" :coefficients="coefficient.data" :state="state"></item-state>
    </template>
</template>

<script setup>
import {useApi} from '@/compositions/CallApi.vue';
import {ref, onMounted, defineProps, defineEmits, watch} from "vue";
import ItemState from "./itemState.vue";

const props = defineProps({
    yearMonth: {
        required: true,
    },
    coefficient: {
        required: true,
    }
});
const api = useApi();
const states = ref([]);
const yearMonth = ref(props.yearMonth);
const coefficient = ref(props.coefficient);
const data=ref({})
watch(()=>props.yearMonth,(newVal,oldVal)=>{
    yearMonth.value = newVal;
    reset()
    load()

})
watch(()=>props.coefficient,(newVal,oldVal)=>{
    coefficient.value=newVal
    reset()
    load()
})
function reset(){
    states.value = [];
    yearMonth.value = props.yearMonth;
    coefficient.value = props.coefficient;
    data.value={}
}
function load(){
    api.post('register/edit',{coefficient:coefficient.value.title, yearMonth:yearMonth.value});
    api.get('state')
        .then(response=>{
            states.value=response.data;
            console.log(states);
        })
    ;
}

function sumStateVal(id){

    let sum = 0;
    Object.entries(data.value).filter(row=>{
        let [index,val]=row;
        if (Number.parseInt(index.split('_'))==id)
            return val;
    }).forEach(row=>{
        let [index,val]=row;
        let [SID, CID, NID] = index.split('_');
        let c=Object.entries(coefficient.value.data).filter(row=>{
            let [index, data] = row;
            // debugger
            if (data.id==Number.parseInt(CID) && data.news_id==Number.parseInt(NID))
                return true;
            return false;
        })[0];
        sum += Number.parseInt(val) * Number.parseInt(c[1].coefficient);
    })
    return sum;
}
function save(){}

function isRegistered({id}){
    return id != null && id != undefined;
}
onMounted(()=>{
    load();
})
</script>

<style scoped>

</style>
