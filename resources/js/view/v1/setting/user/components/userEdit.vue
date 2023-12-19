<template>
    <v-card>

        <v-card-text>
            <v-row class="bg-amber rounded-shaped">
                <v-col cols="12">
                    <v-card-title class="rounded-pill text-center">{{data.firstname}} {{data.lastname}}</v-card-title>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-list class="rounded-shaped  v-card">
                        <v-list-item>
                            <v-text-field label="نام" v-model="data.firstname"></v-text-field>
                        </v-list-item>
                        <v-list-item>
                            <v-text-field label="نام خانوادگی" v-model="data.lastname"></v-text-field>
                        </v-list-item>
                        <v-list-item>
                            <v-text-field label="کدملی" v-model="data.nativeid"></v-text-field>
                        </v-list-item>
                        <v-list-item>
                            <v-text-field label="کد شناسایی" v-model="data.username"></v-text-field>
                        </v-list-item>
                        <v-list-item>
                            <v-text-field label="رمز عبور" v-model="data.password"></v-text-field>
                        </v-list-item>
                        <v-list-item>
                            <v-select label="استان" v-model="data.state_id" item-value="id" :items="props.states"></v-select>
                            {{data.state_id}}
                        </v-list-item>
                    </v-list>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-list  class="rounded-shaped v-card">
                        <v-list-item>
                            <v-text-field label="تلفن ثابت" v-model="data.phone"></v-text-field>
                        </v-list-item>
                        <v-list-item>
                            <v-text-field label="کد پستی" v-model="data.zipCode"></v-text-field>
                        </v-list-item>
                        <v-list-item>
                            <v-text-field label="پست الکترونیکی" v-model="data.email"></v-text-field>
                        </v-list-item>
                        <v-list-item>
                            <v-text-field label="شماره ثابت" v-model="data.phone"></v-text-field>
                        </v-list-item>
                        <v-list-item>
                            <v-text-field label="شماره همراه" v-model="data.mobile"></v-text-field>
                        </v-list-item>
                        <v-list-item>
                            <v-text-field label="آدرس" v-model="data.address"></v-text-field>
                        </v-list-item>
                        <v-list-item>
                            <v-checkbox label="مدیر سیستم" v-model="data.admin"></v-checkbox>
                        </v-list-item>
                    </v-list>
                </v-col>
                <v-col cols="12">

                    <v-card-actions class="v-toolbar">
                        <v-btn :loading="saveLoading" @click="update" prepend-icon="mdi-content-save">ویرایش</v-btn>
                    </v-card-actions>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script setup>
import {computed, defineProps, onBeforeMount, onBeforeUnmount, onMounted, ref} from "vue";
import {useApi} from '@/compositions/CallApi.vue';

const api = useApi();
const props=defineProps({
    item:{
        type:Object,
        default:{},
        required:true,
    },
    col:{
        type:Number,
        default: 1,
    },
    states:{
        type:Array,
        default: [],
    }
})
const states = ref([]);
const saveLoading = ref(false);
const item = ref(props.item);
const col = ref(props.col);
const data = ref(JSON.parse(JSON.stringify(props.item)));
function update(){
    api.post('user/update', data.value)
    .then(response=>{
        item.edit = false;
    })
    .finally(()=>{
        saveLoading.value = false;
    })
}
onMounted(()=>{
    data.value.state = props.item.state?.id;
})
onBeforeUnmount(()=>{
    data.value = {};
})

</script>

<style scoped>

</style>
