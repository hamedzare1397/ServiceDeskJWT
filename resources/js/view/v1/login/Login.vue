<template>
        <v-sheet class="w-100 bg-transparent">
            <transition mode="out-in" :duration="{enter:5000,leave:300}"

                        enter-active-class="animate__animated animate__backInLeft"
                        leave-active-class="animate__animated animate__backOutRight"
            >
                    <form-login>
                        <template v-slot:logo>
                            <v-img height="128" :src="logoAddress"></v-img>
                        </template>
                        <template v-slot:underForm>
                        </template>
                    </form-login>
                </transition>
        </v-sheet>
</template>

<script setup>

import {inject, ref} from "vue";
const appName = inject('config').appName;
import FormLogin from './FormLogin.vue';

const logoAddress=inject('config').logo;

</script>

<style scoped>

</style>
