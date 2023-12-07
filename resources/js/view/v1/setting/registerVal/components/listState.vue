<template>
    <template v-for="(state,index) in states">
        <v-list-item-title><pre>s{{coefficient_id}}s</pre></v-list-item-title>
        <item-state
            :year-month="yearMonth"
            :coefficients="coefficient"
            :state="state"
        ></item-state>
    </template>
</template>

<script setup>
import {useApi} from '@/compositions/CallApi.vue';
import {ref, onMounted, defineProps, defineEmits, watch, reactive} from "vue";
import ItemState from "./itemState.vue";

const props = defineProps({
    yearMonth: {
        required: true,
    },
    coefficient: {
        required: true,
    },
    coefficient_id:{
        type:Number,
        default:0,
    }
});
const api = useApi();
const states = ref([]);
const yearMonth = ref(props.yearMonth);
const coefficient = ref(props.coefficient);
const coefficient_id = ref(props.coefficient_id);
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
    api.post('register/edit',{coefficient:coefficient_id.value, yearMonth:yearMonth.value})
        .then(response=>{
            states.value=response.data;
        })
    ;
}


onMounted(()=>{
    load();
})
</script>

<style scoped>

</style>
