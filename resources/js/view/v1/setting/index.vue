<script setup>
import {computed} from "vue";
import {useRouter} from 'vue-router';

const router = useRouter();

const items = [
    {title:'کاربران',icon:'mdi-account-group',linkName:"App.Setting.User"},
    {title:'استان',icon:'mdi-crosshairs-gps',linkName:"App.Setting.Ostan"},
    {title:'نوع خبر',icon:'mdi-electron-framework',linkName:"App.Setting.News"},
    {title:'ضرایب',icon:'mdi-shape-circle-plus',linkName:"App.Setting.Coefficient"},
    {title:'ثبت امتیازات',icon:'mdi-album',linkName:"App.Setting.Register"},
];
const isSettingPage=computed(()=>{
    return router.currentRoute;
})
</script>
<template>
    <v-sheet v-if="isSettingPage.value.name=='App.Setting'" class="ma-3">
        <v-row>
            <template v-for="item in items">
            <v-col cols="12" sm="6" md="3">
            <router-link
                v-slot="{ isActive, href, navigate }"
                         :to="{name:item.linkName}"
                tag="p"
            >
                <v-card height="200" ripple class="bg-blue-lighten-5">
                    <v-card-title class="text-center">
                        <v-icon class="" size="128">{{item.icon}}</v-icon>
                    </v-card-title>
                    <v-card-title class="text-center">
                        <h3>{{ item.title }}</h3>
                    </v-card-title>
                </v-card>
            </router-link>
            </v-col>
            </template>
        </v-row>
    </v-sheet>
    <template v-else>
        <router-view v-slot="{Component}">
            <component :is="Component">
            <template #toolbar>
                <v-btn class="" @click="router.push({name:'App.Setting'})" prepend-icon="mdi-cogs">تنظیمات</v-btn>
            </template>
            </component>
        </router-view>
    </template>
</template>
