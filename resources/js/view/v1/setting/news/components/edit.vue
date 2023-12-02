<template>
    <v-card>
        <v-row>
            <v-col cols="12"
                   v-for="field in fields"
                   sm="6" md="4">
                <template v-if="field.type=='text' || field.type=='number'">
                    <v-text-field
                        v-model="data[field.name]"
                        :label="field.title"
                        :type="field.type"
                    ></v-text-field>
                </template>
            </v-col>
            <v-col cols="12">
                <v-btn :loading="saveLoading" prepend-icon="mdi-content-save" @click.stop="save">ویرایش</v-btn>
            </v-col>
        </v-row>
    </v-card>
</template>

<script setup>
import {defineProps, defineEmits, computed,ref, reactive} from "vue";
import {useApi} from '@/compositions/CallApi.vue';
const props=defineProps({
    urlApi:{
        required:true,
        type:String,
    },
    item:{
        required:true,
        type:Object,
    },
})
const emits = defineEmits(['updated']);
const address = ref(props.urlApi);
const api = useApi();

const data = reactive(props.item);

const saveLoading=ref(false)

const fields=computed(()=>{
    return [
        {name: 'name',title: 'نام', type:'text'},
    ];
})
function save(){
    saveLoading.value = true;
    api.post(`${address.value}/update`,data)
        .then(response => {
            emits(`updated`, response.data);
        })
        .finally(() => {
            saveLoading.value = false;
        });
}

</script>

<style scoped>

</style>
