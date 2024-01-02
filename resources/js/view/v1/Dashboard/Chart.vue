<template>
    <v-card class="bg-deep-purple-lighten-5">
        <v-card-text>
            <canvas id="chart" class=""></canvas>
        </v-card-text>
        <v-card-actions>
            <v-select density="compact" v-model="typeChart" :items="[
                    {title:'خطی',value:'line'},
                    {title:'دایره ای',value:'pie'},
                    {title:'ستونی',value:'bar'},
                    {title:'نقطه ای',value:'scatter'},
                    {title:'doughnut',value:'doughnut'},
                ]"></v-select>

        </v-card-actions>
    </v-card>

</template>

<script setup>
import {defineProps, onMounted, onUnmounted, reactive, ref, watch} from "vue";
import colors from 'vuetify/lib/util/colors'
import Chart from 'chart.js/auto';

const props= defineProps({
    data:{
        type:Object,
        default:{}
    }
})
const typeChart = ref('bar');
const data = reactive(props.data);
let chartView=null;
const plugin = {
    id: 'chart',
    beforeDraw: (chart, args, options) => {
        const {ctx} = chart;
        ctx.save();
        ctx.globalCompositeOperation = 'destination-over';
        ctx.fillStyle = options.color || colors.lightGreen.accent1;
        ctx.fillRect(0, 0, chart.width, chart.height);
        ctx.restore();
    }
};
onMounted(()=>{
    chartView=new Chart(
        document.getElementById('chart'),
        {
            type: typeChart.value,
            data: {
                labels: data.label,
                datasets: [
                    {
                        label:`رتبله بندی استان ها`,
                        data: data.val,
                        backgroundColor:data.colors
                    }
                ],
                hoverOffset: 10
            },
            options: {scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                },
                plugins: {
                    customCanvasBackgroundColor: {
                        color: colors.amber.accent1,
                    },
                    interaction: {
                        // Overrides the global setting
                        mode: 'index'
                    }
                },
            },
            plugins:[plugin]
        }
    );
})

watch(data,(newVal,oldVal)=>{
    chartView.data.labels=newVal.label;
    chartView.data.datasets[0].data = newVal.val;
    chartView.data.datasets[0].backgroundColor = newVal.colors;
    chartView.update();
})
watch(typeChart,(newVal,oldVal)=>{
    chartView.config.type = newVal;
    chartView.update();
})
onUnmounted(()=>{
    chartView.destroy();
})
</script>
