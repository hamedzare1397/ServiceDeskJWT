<template>
    <v-card>
        <v-card-title class="bg-error">حذف {{ item.title }}</v-card-title>
        <v-card-text>
            <p class="my-3">
                آیا از حذف نوع خبر با نام
                    <strong class="font-weight-bold text-white rounded-pill px-2 bg-error">{{item.name}}</strong>
                و
                    با عنوان
                    <strong class="font-weight-bold text-white rounded-pill px-2 bg-error">{{item.title}}</strong>
                اطمینان دارید؟
            </p>
        </v-card-text>
        <v-card-actions>
            <v-btn color="error" :loading="deleteLoading" :disabled="deleteLoading" variant="tonal" prepend-icon="mdi-delete-forever" @click="deleteItem">حذف</v-btn>
            <v-btn color="success" variant="tonal" prepend-icon="mdi-close" @click="cancel">انصراف</v-btn>
        </v-card-actions>
    </v-card>
</template>

<script setup>
import {ref, defineEmits, defineProps, reactive} from "vue";
import {usePost} from '@/compositions/CallApi.vue';
const props = defineProps({
    urlApi:{
        type:String,
        required:true,
    },
    item:{
        type:Object,
        required:true,
    }
});
const emits = defineEmits(['deleted']);
const deleteLoading = ref(false);
const item = reactive(props.item);
function deleteItem(){
    deleteLoading.value = true;
    let {response,data} = usePost(`${props.urlApi}/delete`,{id:item.id},{},deleteLoading);
    emits(`deleted`, data);
}
function cancel(){
    item.deleteShow = false;
}
</script>

<style scoped>

</style>
