<template>
    <div style="width: 400px">
        <div style="display: flex; justify-content: center">
            <button type="button" @click="shuffleData">Add data</button>
        </div>
        <h1>sl</h1>
        <pre dir="ltr">{{props.states }}</pre>
        <DoughnutChart v-bind="doughnutChartProps" />
    </div>
</template>

<script setup>
import { computed, defineProps, ref } from "vue";
import { DoughnutChart, useDoughnutChart } from "vue-chart-3";
import {Chart, registerables } from "chart.js";

Chart.register(...registerables);

const props=defineProps({
data:{type:Object,required:true},
states:{type:Array,required:true},
})
const dataValues = ref(props.data);
const dataLabels = ref(props.states);
const toggleLegend = ref(true);

const testData = computed(() => ({
    labels: dataLabels.value,
    datasets: [
        {
            data: dataValues.value,
            backgroundColor: [
                "#77CEFF",
                "#0079AF",
                "#123E6B",
                "#97B0C4",
                "#A5C8ED",
            ],
        },
    ],
}));

const options = computed(() => ({
    scales: {
        myScale: {
            type: "logarithmic",
            position: toggleLegend.value ? "left" : "right",
        },
    },
    plugins: {
        legend: {
            position: toggleLegend.value ? "top" : "bottom",
        },
        title: {
            display: true,
            text: "Chart.js Doughnut Chart",
        },
    },
}));

const { doughnutChartProps, doughnutChartRef } = useDoughnutChart({
    chartData: testData,
    options,
});

let index = ref(20);

function shuffleData() {
    // dataValues.value = shuffle(dataValues.value);
    dataValues.value.push(index.value);
    dataLabels.value.push("Other" + index.value);
    console.log(dataValues.value);
    console.log(doughnutChartRef.value.chartInstance);
    index.value++;
}

function switchLegend() {
    toggleLegend.value = !toggleLegend.value;
}

</script>

<style>
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
}
</style>
