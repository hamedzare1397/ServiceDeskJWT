<template>
    <pre>{{yearMonth}}</pre>
    <pre>{{coefficient}}</pre>
</template>

<script setup>
import {useApi} from '@/compositions/CallApi.vue';
import {ref, onMounted, defineProps, defineEmits, watch} from "vue";

const props = defineProps({
    yearMonth: {
        required: true,
    },
    coefficient: {
        required: true,
    }
});
const api = useApi();
const yearMonth = ref(props.yearMonth);
const coefficient = ref(props.coefficient);

watch(()=>props.yearMonth,(newVal,oldVal)=>{
    yearMonth.value = newVal;
    load()

})
watch(()=>props.coefficient,(newVal,oldVal)=>{
    coefficient.value=newVal
    load()
})
function reset(){

}
function load(){
    api.post('register/edit',{coefficient:coefficient.value, yearMonth:yearMonth.value});
}
onMounted(()=>{
    load();
})
</script>

<style scoped>

</style>
