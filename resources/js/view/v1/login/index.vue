<template>
    <v-layout>
        <v-app class="bgimage">
            <v-app-bar theme="dark" elevation="1" :title="appName" order="0"></v-app-bar>
            <div class="w-100 h-100 d-flex justify-center align-center ">
                <Login></Login>
            </div>
            <v-footer app>
                <v-row class="text-center">
                    <v-col>
                        <sub>تمامی حقوق این نرم افزار متعلق به شرکت داده نگار هیوا پارس می باشد</sub>
                    </v-col>
                </v-row>
            </v-footer>
        </v-app>
    </v-layout>
</template>

<script setup>

import {defineComponent, inject} from "vue";
import Login from './Login.vue';
const appName = inject('config').appName;
defineComponent(['Login'])
</script>

<style scoped>
.bgimage{
    background-image: url("/storage/images/bg-left.jpg");
    background-position: center;
    background-size: cover;
}
body{
    font-family: "Times New Roman"
}
</style>
