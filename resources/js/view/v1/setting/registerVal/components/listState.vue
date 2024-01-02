<template>
        <v-alert color="warning" v-if="existsAnOther">
            <p>            برای این دوره تیپ دیگری در سیستم ثبت شده است در صورت تمایل به حذف اطلاعات پیشین را بزنید.</p>
            <v-btn color="error" @click.stop="showDeleteMessage=!showDeleteMessage" >حذف</v-btn>
        </v-alert>
        <template v-for="(state,index) in states">
            <v-list-item-title>
            </v-list-item-title>
            <item-state
                :year-month="yearMonth"
                :coefficients="coefficient"
                :state="state"
            ></item-state>
        </template>
    <v-dialog v-model="showDeleteMessage"
              width="auto">
        <v-card>
            <v-card-title class="bg-error">
                <v-icon>mdi-trash-can-outline</v-icon>
                <span>حذف کلیه داده های تیپ و دوره انتخاب شده</span>
            </v-card-title>
            <v-card-text><p>آیا برای حذف اطمینان دارید؟</p></v-card-text>
            <v-card-actions>
                <v-btn variant="elevated" color="error" @click.stop="deleteAnOtherData">حذف</v-btn>
                <v-btn variant="elevated" color="success" @click="showDeleteMessage=!showDeleteMessage">انصراف</v-btn>
            </v-card-actions>
        </v-card>

    </v-dialog>
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
const existsAnOther = ref(false);
const data = ref({});
const showDeleteMessage = ref(false);
watch(()=>props.yearMonth,(newVal,oldVal)=>{
    reset()
    load()

})
watch(()=>props.coefficient,(newVal,oldVal)=>{
    reset()
    load()
})
function reset(){
    states.value = [];
    yearMonth.value = props.yearMonth;
    coefficient.value = props.coefficient;
    coefficient_id.value = props.coefficient_id;
    data.value={}
}
function load(){
    api.post('register/edit',{coefficient:coefficient_id.value, yearMonth:yearMonth.value})
        .then(response=>{
            states.value=response.data.state;
            existsAnOther.value=response.data.existsAnOther;
        })
    ;
}

function deleteAnOtherData(){

    api.post('register/delete',{coefficient:coefficient_id.value, yearMonth:yearMonth.value})
        .then(response=>{})
    ;
}


onMounted(()=>{
    load();
})
</script>

<style scoped>

</style>
