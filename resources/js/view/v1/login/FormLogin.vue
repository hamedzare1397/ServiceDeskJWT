<template>
    <v-row>
        <v-col cols="12" sm="8" md="4" offset="0" offset-md="4" offset-sm="2">
    <v-sheet elevation="10" class="pa-6"
             border=
             rounded>
        <v-row>
            <v-col cols="12">
                <slot name="logo"></slot>
                <v-card-title class="text-center">{{ appName }}</v-card-title>
                <v-text-field v-model="person.username" label="نام کاربری"
                      prepend-icon="mdi-account"
                      :error="errorMessage"
                      :error-messages="errorMessage"
                ></v-text-field>
                <v-text-field 
                v-model="person.password" label="رمز عبور" type="password"
                              prepend-icon="mdi-lock"
                              @keyup.enter="login"
                ></v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <v-btn prepend-icon="mdi-login" :loading="isLoading" :disabled="isLoading" @click="login">ورود</v-btn>
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
import {computed, inject, reactive, ref} from "vue";
import {useAuthStore} from "@/store/user.js";
import {useRouter} from 'vue-router';
const appName=inject('config').organ

const person=reactive({
    username:ref(''),
    password:ref(''),
})

const isLoading = ref(false);
const errorMessage = ref(null);
const authStore = useAuthStore();
const router = useRouter();

async function login(){
    isLoading.value = true;
    errorMessage.value = null;
    authStore.login(person)
        .then((response) => {
            router.push({name:'App.Dashboard'});
        })
        .catch(errors=>{
            errorMessage.value = errors.response?.data?.username;
        })
        .finally(() => {
            isLoading.value = false;
        });
    }

</script>

<style scoped>

</style>
