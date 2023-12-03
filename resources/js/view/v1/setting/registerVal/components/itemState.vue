<template>
    <v-list class="mb-5">
        <v-list-item-title class="bg-blue-accent-1 rounded-t-lg text-center">
            <h3>{{state.title}}</h3>
        </v-list-item-title>
        <v-list-item class="border-b-md rounded-b-lg">
            <v-row>
                <template v-for="(item,index) in coefficients">
                    <v-col cols="12" sm="6" md="4" lg="3">

                        <v-text-field
                            :messages="`ضریب ${item.coefficient}`"
                            :label="item.news.name"
                            v-model="val[item.news.id]"
                        ></v-text-field>
                    </v-col>
                </template>
                <v-col cols="12" sm="6" md="4" lg="3">
                    <v-label>جمغ امتیازات</v-label>
                    <v-label>{{ sum() }}</v-label>
                </v-col>
            </v-row>
            <v-list-item-action>
                <v-btn prepend-icon="mdi-content-save">ثبت</v-btn>
            </v-list-item-action>
        </v-list-item>
    </v-list>
</template>

<script setup>
import {defineProps, onMounted, reactive, ref, watch} from "vue";
import {useApi} from '@/compositions/CallApi.vue';

const api=useApi();

const props=defineProps({
    yearMonth:{
        type:String,
        default:'',
    },
    coefficients:{
        type:Object,
        default:{},
    },
    state:{
        type:Object,
        default:{id:0,title:'انتخاب نشده است'}
    }
});

const state = ref(props.state);
const yearMonth = ref(props.yearMonth);
const coefficients = ref(props.coefficients);

const val = reactive({});
function sum (){
    let s = 0;
    Object.entries(val).forEach(row=>{
        let [i,v]=row;
        let c=Object.entries(coefficients.value).filter(r=>{
            let [index, data] = r;
            if (data.news_id==Number.parseInt(i))
                return true;
            return false;
        })[0];
        s += Number.parseInt(v) * Number.parseInt(c[1].coefficient);
    })
    return s;
};

watch(()=>props.yearMonth,(newVal,oldVal)=>{
    yearMonth.value = newVal;

})
watch(()=>props.coefficients,(newVal,oldVal)=>{
    coefficient.value=newVal
})

onMounted(()=>{
    console.log(coefficients.value);
    debugger
    api.get(`register/val/${state.value.id}/${yearMonth.value}/${coefficients.value.id}`)
        .then(response=>{
            console.log(response)
        })
        .catch(error=>{
            alert.error.message
        })
})

</script>

<style scoped>

</style>
