<template>
    <v-row>
        <v-col cols="12" sm="8" md="4" offset="0" offset-md="4" offset-sm="2">
    <v-sheet elevation="10" class="pa-6"
             border=
             rounded>
        <v-row>
            <v-col cols="12">
                <slot name="logo"></slot>
                <v-card-title>{{ appName }}</v-card-title>
                <v-text-field v-model="person.username" label="نام کاربری"
                      prepend-icon="mdi-account"
                      :error="errorMessage"
                ></v-text-field>
                <v-text-field v-model="person.password" label="رمز عبور"
                              prepend-icon="mdi-lock"
                ></v-text-field>
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
import {useRouter} from 'vue-router';
const appName=inject('config').organ

const person=reactive({
    username:ref('zarssasdsadehmd'),
    password:ref('123123'),
})
const isLoading = ref(false);
const errorMessage = ref(null);
const authStore = useAuthStore();
const router = useRouter();

async function login(){
    isLoading.value = true;
    errorMessage.value = null;
    authStore.login(person)
        .then(response => {
            if (response.status == 200) {
                router.push({name:'dashboard'});
            }
        })
        .catch(err=>{
            alert('error');
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
