<template>
        <v-list v-model:opened="open">
            <template  v-for="nav in navigations">
                <router-link v-slot="{ isActive, href, navigate }" v-if="nav.childs.length<=0"
                             :to="{name:nav.linkName}"
                >
                    <v-list-item
                        :prepend-icon="nav.icon.icon" :title="nav.title">
                    </v-list-item>
                </router-link>
            <v-list-group v-else :value="nav.name">
                <template v-slot:activator="{ props }">
                    <v-list-item
                        v-bind="props"
                        prepend-icon="mdi-account-circle"
                        :title="nav.title"
                    ></v-list-item>
                </template>

                <router-link v-for="childNav in nav.childs"
                             v-slot="{ isActive, href, navigate }"
                             :to="{name:childNav.linkName}"
                >
                <v-list-item
                             :title="childNav.title"
                             :prepend-icon="childNav.icon.icon">

                </v-list-item>

                </router-link>
            </v-list-group>
            </template>
        </v-list>
</template>
<script setup>
import {useUserStore} from "@/store/user.js";
import {storeToRefs} from "pinia";
import {ref} from "vue";

const userStore = useUserStore();
const {navigations} = storeToRefs(userStore);

const open = ref('Users');
</script>

<style scoped>

</style>
