<template>
    <v-row v-for="(state,index) in states" :class="[index%2==0?'bg-blue-lighten-5':'bg-blue-lighten-4']">
        <v-col cols="12">
            <v-label>استان {{state.title}}</v-label>
        </v-col>
        <v-col v-for="item in coefficient.data" >{{item}}
            <v-text-field :label="item.news.name" v-model="data[state.id,item.id]"></v-text-field>
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
    load()

})
watch(()=>props.coefficient,(newVal,oldVal)=>{
    coefficient.value=newVal
    load()
})
function reset(){

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
onMounted(()=>{
    load();
})
</script>

<style scoped>

</style>
