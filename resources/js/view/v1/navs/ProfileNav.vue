<template>
<v-card

    theme=""
>
    <v-list>
        <v-list-item
            :prepend-avatar="information.avatar?information.avatar:false"
            :prepend-icon="information.avatar?false:'mdi-account'"
            nav
        >
            <template v-slot:append>
                <v-list-item-title>{{`${fullname}`}}</v-list-item-title>
            </template>
        </v-list-item>
    </v-list>
    <v-card-actions class="bg-white">
        <v-btn
            variant="text"
            :icon="!showRailNav?'mdi-chevron-right':'mdi-chevron-left'"
            @click.stop="showRailNav = !showRailNav"
        ></v-btn>
<!--        <v-btn disabled-->
<!--            variant="text"-->
<!--            :icon="expandNav?'mdi-pin':'mdi-pin-off'"-->
<!--            @click.stop="expandNav = !expandNav"-->
<!--        ></v-btn>-->
        <v-btn
            variant="text"
            icon="mdi-refresh"
            @click.stop="getUserInfo"
            :loading="isLoadingUserInformation"
        ></v-btn>
    </v-card-actions>
</v-card>
</template>

<script setup>

import {useUserStore} from "@/store/user.js";
import {useAppStore} from "@/store";
import {storeToRefs} from "pinia";
import {computed, ref} from "vue";

const userStore = useUserStore();
const appStore = useAppStore();
const {information} = storeToRefs(userStore);
const {showRightNav, showRailNav,expandNav} = storeToRefs(appStore);
const fullname=computed(()=>{
    if (information.value.firstname!=undefined &&information.value.firstname!='' && information.value.lastname!=undefined && information.value.lastname!='')
        return information.value.firstname + ' ' + information.value.lastname;
    else
        return information.value.username;
})
const isLoadingUserInformation = ref(false);
function getUserInfo(){
    isLoadingUserInformation.value = true;
    userStore.getData()
        .finally(()=>{
            isLoadingUserInformation.value = false;
        })
    ;
}
</script>

<style scoped>

</style>
