<script setup>
import {onMounted, ref} from "vue";
import {useApi} from '@/compositions/CallApi.vue';
import ListState from "./components/listState.vue";

const api = useApi();
const items = ref([]);
const coefficient = ref(null);
const year_month = ref(null);
const loadingCoefficient = ref(false);
onMounted(()=>{
    loadingCoefficient.value = true;
    api.get('coefficient')
    .then(response=>{
        items.value = response.data;
    })
    .finally(()=>{
        loadingCoefficient.value = false;
    })
})
</script>
<template>
    <v-sheet>
    <v-toolbar>
        <slot name="toolbar"></slot>
    </v-toolbar>
    <v-sheet class="h-100">
        <v-row>
            <v-col cols="12" sm="6" md="4">
                <v-select
                    density="compact"
                    :items="items"
                    label="تیپ امتیازات"
                    item-value="id"
                    v-model="coefficient"
                ></v-select>
            </v-col>
            <v-col cols="12" sm="6" md="4">
                <PDatePicker
                    label="دوره"
                    view="year"
                    type="year-month"
                    v-model="year_month"
                    displayFormat="jYYYY/jMM"
                    format="jYYYY-jMM"
                >
                </PDatePicker>
            </v-col>
        </v-row>
        <v-row v-if="coefficient!=null && year_month!=null">
            <v-col cols="12">
                <list-state :coefficient="coefficient" :yearMonth="year_month"></list-state>
            </v-col>
        </v-row>
    </v-sheet>
</v-sheet>
</template>


<style scoped>

</style>
