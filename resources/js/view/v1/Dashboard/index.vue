<script setup>
import chart from './Chart.vue'
import colors from 'vuetify/lib/util/colors'
import moment from 'moment-jalaali';
import {onMounted, reactive, ref, watch} from "vue";
import {useApi} from '@/compositions/CallApi.vue';
const registersVal = ref([]);
const data = reactive({
    label:[],
    val:[],
    rank:[],
    colors:[],
});

const loading = ref(false);
const type = ref('month');
const values = ref(moment(moment.now()).format('jYYYY-jMM'));
const api = useApi();
function refreshData(){
    let link=`statics/?type=${typeSelected.value}&year_month=${values.value}&`;
    if (typeSelected.value != 'year')
    {
        link += link + `typeVal=${typeVal.value}&`;
    }
    loading.value = true;
    api
        .get(link)
        .then(response => {
            data.label = [];
            data.rank = [];
            data.val = [];
            data.colors = [];
            registersVal.value = response.data;
        })
        .finally(()=>{
            loading.value = false;
        })
    ;
}

function pickRandomProperty(obj) {
    var result;
    var count = 0;
    for (var prop in obj){
        let rnd = Math.random()
        let test = 1 / ++count;
        if (rnd<test) {
            let exists = data.colors.filter(row => {
                return prop == row
            });
            if (exists.length<=0) {
                result=prop
            }
        }
    }
    return result;
}

watch(registersVal,(newVal, oldValue)=>{
    Object.entries(newVal).forEach(row=> {
        let color=pickRandomProperty(colors)
        let subColor = pickRandomProperty(colors[color]);
        let [index, val] = row;
        data.label.push(val.state.title);
        data.val.push(val.mvalue);
        data.rank.push(val.rank);
        data.colors.push(colors[color].lighten1);
    })
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
    values.value = moment(moment.now()).format('jYYYY-jMM');
    if (typeSelected.value=='3month' || typeSelected.value=='6month') {
        values.value = moment(moment.now()).format('jYYYY');
        typeVal.value = 1;
    }
    else if(typeSelected.value=='year') {
        values.value=moment(moment.now()).format('jYYYY');
        typeVal.value = null;
    }
    else if(typeSelected.value=='month') {
        values.value=moment(moment.now()).format('jYYYY-jMM')
        typeVal.value = null;
    }
})

</script>
<template>
<v-card class="h-100">
    <v-card-actions class="d-flex align-content-center">
    <v-row class="">
        <v-col cols="12" sm="3">
                <v-select prepend-icon="mdi-periodic-table" :items="typeItems" density="compact" v-model="typeSelected"></v-select>
            </v-col>
        <v-col cols="12" sm="3">
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
        <v-col cols="12" sm="3" v-if="typeSelected=='3month' || typeSelected=='6month'">
            <v-select
                prepend-icon="mdi-cube"
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
        <v-col cols="12" sm="1">
            <v-btn
                :loading="loading"
                size="" variant="outlined" icon="mdi-refresh" @click="refreshData" density="comfortable"></v-btn>
        </v-col>
    </v-row>
    </v-card-actions>

    <v-sheet class="h-100" v-if="data.val.length>0">
        <v-row>
        <v-col cols="12" sm="5" md="3">
            <v-table class="h-100 mr-10 v-responsive" density="compact"
                     fixed-header>
                <thead>
                <tr>
                    <th  class="text-center bg-blue-darken-1" width="25">رتبه</th>
                    <th  class="text-center bg-blue-darken-1">استان</th>
                    <th class="text-center  bg-blue-darken-1">امتیاز</th>
                </tr>
                </thead>
                <tr v-for="(item,index) in data.label" :style="`background-color: ${data.colors[index]}`">
                    <td class="text-center">{{data.rank[index]}}</td>
                    <td class="text-center">{{ item }}</td>
                    <td class="text-center">{{data.val[index]}}</td>
                </tr>
            </v-table>
        </v-col>
        <v-col cols="12" sm="7" md="9">
            <chart v-if="registersVal" :data="data"></chart>
        </v-col>
    </v-row>
    </v-sheet>
    <v-sheet
        v-else-if="!loading"
        class="text-center d-flex justify-center align-center h-100"
        color="warning"
    >
        <div>
            <v-icon size="150">mdi-alert-box</v-icon>
            <v-spacer></v-spacer>
            <h1>هیچ داده ای موجود نمی باشد</h1>
        </div>
    </v-sheet>
    <v-sheet v-else>

    </v-sheet>
</v-card>
</template>
<style scoped>

</style>
