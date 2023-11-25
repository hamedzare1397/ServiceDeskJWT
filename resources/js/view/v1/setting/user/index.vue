<template>
<v-sheet>
    <v-toolbar>
        <slot name="toolbar"></slot>
        <v-btn icon="mdi-refresh" :loading="isLoading" @click="getUsers(page)"></v-btn>
    </v-toolbar>
    <v-sheet class="bg-amber h-100">
        <datatables :items="users.data"
                    :headers="header"
                    :loading="isLoading"
                    :headers-append="[
                        {key:'actions'},
                    ]"
                    :headers-prepend="[
                        {key:'row'},
                    ]"
                    :total="users.total"
                    :page="page"
                    :perPage="perPage"
                    @update:page="getUsers"
        >
            <template #row="{index}">{{ (index+1)+((page-1)*perPage) }}</template>
            <template v-slot:actions>
                <v-btn-group density="compact">
                    <v-btn icon="mdi-pencil"></v-btn>
                    <v-btn icon="mdi-badge-account-outline"></v-btn>
                </v-btn-group>
            </template>
        </datatables>
    </v-sheet>
</v-sheet>
</template>

<script setup>
import {reactive, ref} from "vue";
import Datatables from "./../../Components/datatables.vue";
import {useApi} from "@/compositions/CallApi.vue";

const api = useApi();
const isLoading = ref(false);
const header = reactive([
    {title: 'نام', key: 'firstname'},
    {title: 'نام خانوادگی', key: 'lastname'},
    {title: 'نام کاربری', key: 'username'},
]);
const action_header = reactive([
    {title: 'نام', key: 'actions'},
]);
const users = ref([]);
const page = ref(1);
const perPage = ref(10);
function getUsers(event){
    page.value = event;
    isLoading.value = true;
    api.post(`user?user-page=${page.value}`)
        .then(response => {
            users.value = response.data;
        })
    .finally(()=>{
        isLoading.value = false;
    })
    ;
}
</script>

<style scoped>

</style>
