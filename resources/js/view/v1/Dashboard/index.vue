<script setup>
import chart from './Chart.vue'
import moment from 'moment-jalaali';
import {onMounted, reactive, ref, watch} from "vue";
import {useApi} from '@/compositions/CallApi.vue';
const registersVal = ref([]);
const data = reactive({
    label:[],
    val:[],
});

const type = ref('month');
const values = ref(moment(moment.now()).format('jYYYY-jMM'));
const api = useApi();
function refreshData(){
    let link=`statics/?type=${typeSelected.value}&year_month=${values.value}&`;
    if (typeSelected.value != 'year')
    {
        link += link + `typeVal=${typeVal.value}&`;
    }
    api
        .get(link)
        .then(response => {
            data.label = [];
            data.val = [];
            registersVal.value = response.data;
        });
}

watch(registersVal,(newVal, oldValue)=>{
    Object.entries(newVal).forEach(row=> {
        let [index, val] = row;
        data.label.push(val.state.title);
        data.val.push(val.mvalue);
    })
    console.log(data,newVal);
})
const typeSelected = ref('month');
const typeVal = ref(1);
const typeItems = reactive([
    {title:'ماهانه',value:'month'},
    {title:'3 ماهه',value:'3month'},
    {title:'6 ماه',value:'6month'},
    {title:'سالانه',value:'year'},
]);
onMounted(()=>{
    refreshData()
})

watch(typeSelected,(n,o)=>{
    values.value = null;
    typeVal.value = null;
})

</script>
<template>
<v-sheet class="h-100">
    <v-toolbar density="compact">
        <v-btn icon="mdi-refresh" @click="refreshData" density="compact"></v-btn>
    </v-toolbar>
    <v-row>
        <v-col cols="12" md="4">
            <v-select :items="typeItems" density="compact" v-model="typeSelected"></v-select>
        </v-col>
        <v-col cols="12" md="4">
            <PDatePicker
                label="دوره"
                view="year"
                :type="typeSelected=='month'?'year-month':'year'"
                v-model="values"
                :displayFormat="typeSelected=='month'?'jYYYY/jMM':'jYYYY'"
                :format="typeSelected=='month'?'jYYYY/jMM':'jYYYY'"
            >
            </PDatePicker>
        </v-col>
        <v-col cols="12" md="4" v-if="typeSelected=='3month' || typeSelected=='6month'">
            <v-select
                density="compact"
                placeholder="انتخاب نشده"
                v-model="typeVal"
                :items="typeSelected=='3month'?
            [
                {title:'سه ماهه اول',value:1},
                {title:'سه ماهه دوم',value:2},
                {title:'سه ماهه سوم',value:3},
                {title:'سه ماهه چهارم',value:4},
            ]:[
                {title:'شش ماهه اول',value:1},
                {title:'شش ماهه دوم',value:2},
            ]"
            ></v-select>
        </v-col>
    </v-row>
    <v-row class="h-100">
        <v-col cols="12" md="4" class="order-md-1">
            <chart v-if="registersVal" :data="data"></chart>
        </v-col>
        <v-col cols="12" md="4" class="order-md-0">
            <v-table class="h-100">
                <thead>
                <tr>
                    <th width="25">رتبه</th>
                    <th>استان</th>
                    <th>امتیاز</th>
                </tr>
                </thead>
                <tr v-for="(item,index) in data.label">
                    <td>{{index+1}}</td>
                    <td>{{ item }}</td>
                    <td>{{data.val[index]}}</td>
                </tr>
            </v-table>
        </v-col>
    </v-row>
</v-sheet>
</template>
<style scoped>

</style>
