<template>
<v-row>
    <v-col cols="12" sm="10" md="6" offset="0" offset-md="3" offset-sm="1">
        <v-sheet elevation="10" class="px-1 pb-3"
                 border=
                     rounded>
            <slot name="logo"></slot>
            <v-card-title>{{ appName }}</v-card-title>
            <v-row>
                <v-col cols="12" sm="12" md="6">
                    <v-text-field v-model="person.firstname" label="نام"></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                <v-text-field v-model="person.lastname" label="نام خانوادگی"></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                <v-text-field v-model="person.nativeid" label="کد ملی"></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                    <v-text-field v-model="person.mobile" label="شماره همراه"></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                    <v-text-field v-model="person.captcha" label="کد امنیتی"></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-btn :loading="isLoading" :disabled="isLoading" @click="login">ورود</v-btn>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <slot name="underForm"></slot>
                </v-col>
            </v-row>
        </v-sheet>
    </v-col>
</v-row>
</template>

<script setup>
import {inject, reactive, ref} from "vue";
import {useAuthStore} from "@/store/user.js";

const appName=inject('config').organ

const person=reactive({
    firstname:ref(''),
    lastname:ref(''),
    mobile:ref(''),
    nativeId:ref(''),
    captcha:ref(''),
})
const isLoading = ref(false);
const errorMessage = ref(null);
const authStore = useAuthStore();

async function login(){
    isLoading.value = true;
    errorMessage.value = null;
    authStore.loginMobile(person)
        .then(response => {
            console.log(response);
        })
        .catch(err=>{
            console.error(err)
            errorMessage.value = err.response.data;
        })
        .finally(() => {
            isLoading.value = false;
        });
    }

</script>

<style scoped>

</style>
