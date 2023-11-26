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
            <template #row="{index}">
                <td>{{ (index+1)+((page-1)*perPage) }}</td>
            </template>
            <template #actions="{item}">
                <v-btn-group density="compact">
                    <v-btn @click="item.edit=!item.edit;item.show=false" icon="mdi-pencil"></v-btn>
                    <v-btn @click="item.show=!item.show;item.edit=false" icon="mdi-badge-account-outline"></v-btn>
                </v-btn-group>
            </template>
            <template #underRow="{item,colspan}">
                <transition-group
                    mode="in-out"
                    enter-active-class="animate__animated animate__bounceInRight"
                    leave-active-class="animate__animated animate__bounceOutRight"
                >
                <tr v-if="item.show">
                    <td :colspan="colspan">
                        <user-info :item="item"></user-info>
                    </td>
                </tr>
                <tr v-if="item?.edit">
                    <td :colspan="colspan">
                        <user-edit :item="item"></user-edit>
                    </td>
                </tr>
                </transition-group>
            </template>
        </datatables>
    </v-sheet>
</v-sheet>
</template>

<script setup>
import {onMounted, reactive, ref} from "vue";
import Datatables from "./../../Components/datatables.vue";
import {useApi} from "@/compositions/CallApi.vue";
import userInfo from "./components/userInformation.vue";
import userEdit from "./components/userEdit.vue";

const api = useApi();
const isLoading = ref(false);
const header = reactive([
    {title: 'نام استان', key: 'ostan'},
    {title: 'سال', key: 'sal'},
    {title: 'ماه', key: 'mah'},
]);
const action_header = reactive([
    {title: 'نام', key: 'actions'},
]);
const users = ref([]);
const page = ref(1);
const perPage = ref(10);
function getUsers(event=1){
    page.value = event;
    isLoading.value = true;
    api.post(`ostan?ostan-page=${page.value}`)
        .then(response => {
            users.value = response.data;
        })
    .finally(()=>{
        isLoading.value = false;
    })
    ;
}

onMounted(()=>{
    getUsers();
})
</script>

<style scoped>

</style>
