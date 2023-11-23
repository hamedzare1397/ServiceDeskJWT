<template>
    <v-navigation-drawer
        elevation="3"
        location="right"
        v-model="showRightNav"
        :rail="showRailNav"
        :expand-on-hover="expandNav"
        permanent
    >
        <profile></profile>
        <v-divider></v-divider>
        <action-nav></action-nav>
        <div style="bottom: 0px; z-index: 1004; transform: translateY(0%); position: fixed; left: 0px; width: calc((100% - 0px) - 0px);">
        <v-divider></v-divider>
            <v-list>
                <v-list-item>
                    <template v-slot:append>
                        <v-btn-close
                            density="compact"
                            :icon="showRailNav?'mdi-pin-off':'mdi-pin'"
                            size="small"
                            @click="showFooter=!showFooter"></v-btn-close>
                    </template>
                </v-list-item>
            </v-list>
        </div>
    </v-navigation-drawer>
</template>

<script setup>
import Profile from './ProfileNav.vue';
import ActionNav from './ActionNav.vue';
import {useAppStore} from "@/store";
import {storeToRefs} from "pinia";
import {useUserStore} from "@/store/user.js";
import {onBeforeMount, ref} from "vue";

const appStore = useAppStore();
const userStore = useUserStore();
const {showRightNav, showRailNav,showFooter,expandNav} = storeToRefs(appStore);

const {} = storeToRefs(userStore);
onBeforeMount(()=>{
    userStore.getNavigations();
})


</script>

<style scoped>

</style>
