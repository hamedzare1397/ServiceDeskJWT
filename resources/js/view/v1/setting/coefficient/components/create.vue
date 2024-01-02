<template>
<v-card>
    <v-row>
        <v-col cols="12" sm="6" md="4">
            <v-text-field
                    v-model="data.name"
                    label="نام"
                    type="text"
                ></v-text-field>
        </v-col>
        <v-col cols="12" sm="6" md="4">
                <v-select
                    v-model="data.typeNews"
                    label=""
                    :items="newsItems"
                    density="compact"
                    multiple
                    return-object
                    chips
                ></v-select>
        </v-col>
        <v-col cols="12" sm="6" md="4" lg="3" v-for="item in data.typeNews">
            <v-text-field v-model="item.coefficient" :label="`ضریب ${item.title}`"></v-text-field>
        </v-col>
        <v-col cols="12">
            <v-btn :loading="saveLoading" prepend-icon="mdi-content-save" @click.stop="save">ذخیره</v-btn>
        </v-col>
    </v-row>
</v-card>
</template>

<script setup>
import {defineProps, defineEmits, computed, ref, reactive, h, render, onMounted, onBeforeMount} from "vue";
import {useApi,usePost} from '@/compositions/CallApi.vue';
const props=defineProps({
    apiAddress:{
        required:true,
        type:String,
    },
})
const emits = defineEmits(['created']);
const address = ref(props.apiAddress);
const api = useApi();

const data = reactive({});

const saveLoading=ref(false)
const newsItems = ref([]);


function save(){
    saveLoading.value = true;
    api.post(`${address.value}/store`,data)
        .then(response => {
            emits(`created`, response.data);
        })
        .finally(() => {
            saveLoading.value = false;
        });
}

onBeforeMount(async()=>{
        api.get('news')
            .then(response=>{
                newsItems.value = response.data;
            })
})
</script>

<style scoped>

</style>
