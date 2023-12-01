<template>
    <v-app>
        <v-main>
            <v-app-bar elevation="1" :title="appName" image="" order="0">
                <template v-slot:prepend>
                    <v-btn @click="showRightNav=!showRightNav" icon="mdi-menu"></v-btn>
                </template>
                <template v-slot:append>
                    <v-row>
                        <v-col class="ma-n2" cols="12">{{ h }}</v-col>
                        <v-col class="ma-n2" cols="12">{{ d }}</v-col>
                    </v-row>
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
import {useApi} from '@/compositions/CallApi.vue';

const api = useApi();

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


import moment from 'moment-jalaali';

const timeStampFull = ref(null);
const h = ref(0);
const d = ref(0);
api.get('time')
    .then(response=>{
        if (response.status == 200) {
            timeStampFull.value = Number(response.data)* 1000;
            setInterval(startTime, 1000);
        }
    });

function startTime(){
    timeStampFull.value += 1000;
}

watch(timeStampFull,(newVal)=>{
    const tim=moment(newVal);
    h.value=tim.format('h:mm:ss A')
    d.value=tim.format('L')
})
</script>

<style scoped>

</style>
