<template>
    <v-navigation-drawer
        elevation="3"
        location="left"
        v-model="showLeftNav"
        :rail="false"
        :expand-on-hover="expandNav"
        permanent
    >
        <v-list>
            <v-list-item prepend-icon="mdi-account-reactivate"
            @click="goToPage('App.ChangePassword')">
                تغییر رمز عبور
            </v-list-item>
        </v-list>
    </v-navigation-drawer>
</template>

<script setup>
import {useAppStore} from "@/store";
import {storeToRefs} from "pinia";
import {useUserStore} from "@/store/user.js";
import {onBeforeMount, ref} from "vue";
import {useRouter} from 'vue-router';

const router = useRouter();
const appStore = useAppStore();
const {showLeftNav, expandNav} = storeToRefs(appStore);

function goToPage(name){
    router.push({name})
    showLeftNav.value = false;
}

</script>

<style scoped>

</style>
