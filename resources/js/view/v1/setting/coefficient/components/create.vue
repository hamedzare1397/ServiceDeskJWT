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
            <v-btn :loading="saveLoading" prepend-icon="mdi-content-save" @click.stop="save">ذخیره</v-btn>
        </v-col>
    </v-row>
</v-card>
</template>

<script setup>
import {defineProps, defineEmits, computed,ref, reactive} from "vue";
import {useApi} from '@/compositions/CallApi.vue';
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

const fields=computed(()=>{
    return [
        {name: 'name',title: 'نام', type:'text'},
        {name: 'title',title: 'عنوان', type:'text'},
    ];
})
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

</script>

<style scoped>

</style>
