<template>
    <v-app>
        <v-main>
            <v-app-bar elevation="1" :title="appName" image="" order="0">
                <template v-slot:prepend>
                    <v-btn @click="showRightNav=!showRightNav" icon="mdi-menu"></v-btn>
                </template>
                <template v-slot:append>

                        <v-btn icon="mdi-account" size="small" rounded="circle" class="bg-amber"></v-btn>
                        <v-btn
                            icon="mdi-exit-to-app"
                            density="compact"
                            size="small"
                            color="error"
                            elevation="24"
                            @click="logout"
                        ></v-btn>

                </template>
            </v-app-bar>
            <right-nav></right-nav>
            <v-sheet class="w-100 h-100">
                <router-view></router-view>
            </v-sheet>
            <div data-teleport></div>
        </v-main>
    </v-app>
</template>

<script setup>

import {computed, inject, ref} from "vue";
import RightNav from './navs/RightNavs.vue';

import {useAppStore} from '@/store/index.js';

const appName = inject('config').appName;
import {storeToRefs} from 'pinia';
import {useAuthStore} from "@/store/user.js";
const appStore = useAppStore();
const {showRightNav, showRailNav,showFooter} = storeToRefs(appStore);
function setShowRightNav(val){
    console.log(showRightNav);
    showRightNav.value = val;
}

const authStore=useAuthStore()
function logout(){
    authStore.logout();
}


</script>

<style scoped>

</style>
