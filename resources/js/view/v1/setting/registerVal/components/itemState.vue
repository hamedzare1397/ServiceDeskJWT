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
                            :messages="`ضریب ${item.pivot.coefficient}`"
                            :label="item.name"
                            v-model="val[item.pivot.news_id]"
                        ></v-text-field>
                    </v-col>
                </template>
                <v-col cols="12" sm="6" md="4" lg="3">
                    <v-label>جمغ امتیازات</v-label>
                    <v-label>{{ sum() }}</v-label>
                </v-col>
            </v-row>
            <v-list-item-action>
                <v-btn prepend-icon="mdi-content-save" @click.stop="save">
                    <span v-if="state.registers.length<=0">ثبت</span>
                    <span v-else>ویرایش</span>
                </v-btn>
            </v-list-item-action>
        </v-list-item>
    </v-list>
</template>

<script setup>
import {computed, defineProps ,onMounted, reactive, ref, watch} from "vue";
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

const val =reactive({});

function sum (){
    let s = 0;
    if (Object.entries(val).length>0) {
        Object.entries(val).forEach(row => {
            let [i, v] = row;
            let c = Object.entries(coefficients.value)
                .filter(r => {
                    let [index, data] = r;
                    if (data.id == Number.parseInt(i))
                        return true;
                    return false;
                })[0];
            s += Number.parseInt(v) * Number.parseInt(c[1].pivot.coefficient);
        })
    }
    return s;
};

watch(()=>props.yearMonth,(newVal,oldVal)=>{
    yearMonth.value = newVal;

})
watch(()=>props.coefficients,(newVal,oldVal)=>{
    coefficient.value=newVal
})


const sendData=computed(()=>{
    // return {state: state.value.id,yearMonth:yearMonth.value, coefficient: coefficients.value, val}
})

function save(){
    api.post("register/store", {
        state: state.value.id,
        yearMonth:yearMonth.value,
        coefficient: coefficients.value,
        val
    })
        .then(response=>{
            state.value.registers=response.data;
        })
    ;
}
onMounted(()=>{
    let registers = Object.entries(state.value.registers);
    if (registers.length > 0) {
        registers.forEach(row=>{
            let [index,value]=row;
            val[index]=value.value;
        })
    }
    else{

    }
})
</script>

<style scoped>

</style>
