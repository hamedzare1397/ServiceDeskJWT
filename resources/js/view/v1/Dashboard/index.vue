<script setup>
import chart from './Chart.vue'
import {onMounted, reactive, ref, watch} from "vue";
import {useApi} from '@/compositions/CallApi.vue';
const states = ref([]);
const data = reactive({
    label:[],
    val:[],
});

const year = ref(null);
const type = ref('month');
const values = ref(null);
const api = useApi();
function refreshData(){
    api
        .get('statics')
        .then(response => {
            data.label = [];
            data.val = [];
            states.value = response.data;
        });
}

watch(states,(oldVal,newVal)=>{
    Object.entries(newVal).forEach(row=> {
        let [index, {title, name, register_val}] = row;
        data.label.push(title);
        if (register_val.length >= 1) {
            data.val.push(register_val[0].mval);
            console.log(register_val[0]);
        }
        else data.val.push(0);
    })
})
onMounted(()=>{
    refreshData()
})
</script>
<template>
<v-sheet>
    <v-toolbar>
        <v-toolbar-items>
            <v-btn icon="mdi-refresh" @click="refreshData"></v-btn>
        </v-toolbar-items>

        <PDatePicker
            label="دوره"
            view="year"
            type="year-month"
            v-model="values"
            displayFormat="jYYYY/jMM"
            format="jYYYY-jMM"
        >
        </PDatePicker>
        {{values}}
    </v-toolbar>
    <v-row>
        <v-col cols="12" md="4" class="order-md-1">
            <chart v-if="states" :data="data.val"  :states="data.label"></chart>
        </v-col>
        <v-col cols="12" md="4" class="order-md-0">
            <table>
                <thead>header2</thead>
                <tr>
                    <td></td>
                </tr>
            </table>
        </v-col>
    </v-row>
</v-sheet>
</template>


<style scoped>

</style>
