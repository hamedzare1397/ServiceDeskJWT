<template>
    <v-row>
        <v-col cols="12">
            <pre dir="ltr">{{data}}</pre>
        </v-col>
    <v-col cols="12">
        <Bar :data="data" />
    </v-col>
    </v-row>
</template>

<script setup>
import {defineProps} from "vue";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from 'chart.js'
import { Bar } from 'vue-chart-3'

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

const props= defineProps({
    data:{
        type:Object,
        default:{
            datasets:  {
                label: 'Data One',
                data: []
            },
            labels:[],
        }
    }
})


</script>
