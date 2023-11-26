<script setup>
import {computed} from "vue";
import {useRouter} from 'vue-router';

const router = useRouter();

const items = [
    {title:'کاربران',icon:'mdi-account-group',linkName:"App.Setting.User"},
    {title:'استان',icon:'mdi-account',linkName:"App.Setting.Ostan"},
    {title:'نوع خبر',icon:'mdi-account',linkName:"App.Setting.News"},
    {title:'ضرایب',icon:'mdi-account',linkName:"App.Setting.Coefficient"},
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
            >
                <v-card height="200" ripple class="">
                    <div class="d-flex justify-center align-center">
                        <v-icon size="128">{{item.icon}}</v-icon>
                    </div>
                    <v-card-title class="text-center">
                        <h2>{{ item.title }}</h2>
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
