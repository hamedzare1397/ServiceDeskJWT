<template>
    <v-app>
        <v-main>
            <v-app-bar elevation="1" :title="appName" image="" order="0">
                <template v-slot:prepend>
                    <v-btn @click="showRightNav=!showRightNav" icon="mdi-menu"></v-btn>
                </template>
                <template v-slot:append>
                    <v-alert density="compact" color="red">
                        {{ h }}: {{ m }}: {{ s }}
                    </v-alert>
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

import {computed, inject, onMounted, ref, watch} from "vue";
import RightNav from './navs/RightNavs.vue';
import {storeToRefs} from 'pinia';
import {useAuthStore} from "@/store/user.js";
import {useAppStore} from '@/store/index.js';
import router from '@/router';
import {useGetTime} from './../../compositions/timeDateServer.vue';

const {h,m,s} = useGetTime();
const hour = ref(h);

const appName = inject('config').appName;
const appStore = useAppStore();
const {showRightNav, showRailNav,showFooter} = storeToRefs(appStore);
function setShowRightNav(val){
    showRightNav.value = val;
}

const authStore=useAuthStore()
async function logout(){
    let response = await authStore.logout();
    if(response){
        router.push({name: "Login"})
    }
}
const showTime=ref(null)
const currentTime = ref();
onMounted(()=>{

})

</script>

<style scoped>

</style>
