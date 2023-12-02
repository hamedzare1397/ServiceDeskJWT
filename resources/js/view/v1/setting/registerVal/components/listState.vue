<template>
    <v-row v-for="(state,index) in states" :class="[index%2==0?'bg-blue-lighten-5':'bg-blue-lighten-4']">
        <v-col cols="12">
            <v-label>استان {{state.title}}</v-label>
        </v-col>
        <v-col cols="12" sm="6" md="4" lg="3" v-for="item in coefficient.data" >
            <v-text-field :label="item.news.name" v-model="data[`${state.id}_${item.id}_${item.news_id}`]"></v-text-field>
        </v-col>
        <v-col cols="12">
            <v-label>جمع امتیازات</v-label>
            {{ sumStateVal(state.id) }}
        </v-col>
        <v-col cols="12"><pre>
            {{data[state.id]}}
        </pre></v-col>
    </v-row>
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
onMounted(()=>{
    load();
})
</script>

<style scoped>

</style>
