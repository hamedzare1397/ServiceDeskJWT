<template>
    <v-card>
        <pre>{{state}}</pre>
        <v-card-text>
            <v-row class="bg-green-accent-1 rounded-shaped">
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
                            <v-select label="استان" v-model="data.state" item-value="id" :items="props.states"></v-select>
                            {{data.state}}
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
                        <v-btn :loading="saveLoading" @click="save" prepend-icon="mdi-content-save">ثبت</v-btn>
                    </v-card-actions>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script setup>
import {computed, defineProps, onBeforeUnmount, onMounted, ref} from "vue";
import {useApi} from '@/compositions/CallApi.vue';

const api = useApi();
const props=defineProps({
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
const col = ref(props.col);
const data = ref({
    admin:false,
});
function save(){
    api.post('user/store', data.value)
    .then(response=>{

    })
    .finally(()=>{
        saveLoading.value = false;
    })
}
onBeforeUnmount(()=>{
    data.value = {};
})

</script>

<style scoped>

</style>
