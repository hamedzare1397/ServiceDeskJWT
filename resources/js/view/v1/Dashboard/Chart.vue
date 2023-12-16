<template>
    <v-row>
    <v-col cols="12">
        <canvas id="chart" class=""></canvas>
    </v-col>
    </v-row>
</template>

<script setup>
import {defineProps, onMounted, reactive, ref, watch} from "vue";
import Chart from 'chart.js/auto';

const props= defineProps({
    data:{
        type:Object,
        default:{}
    }
})
const data = reactive(props.data);
let chartView=null;
onMounted(()=>{
    chartView=new Chart(
        document.getElementById('chart'),
        {
            type: 'bar',
            data: {
                labels: data.label,
                datasets: [
                    {
                        label:`${data.val.length} استان ${data.val.length>=4?'':'برتر'}`,
                        data: data.val
                    }
                ]
            }
        }
    );
})

watch(data,(newVal,oldVal)=>{
    console.log(chartView.data);
    chartView.data.labels=newVal.label;
    chartView.data.datasets[0].data = newVal.val;
    chartView.update();
})

</script>
