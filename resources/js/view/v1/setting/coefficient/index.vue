<template>
<v-sheet>
    <v-toolbar>
        <slot name="toolbar"></slot>
        <v-btn icon="mdi-refresh" :loading="isLoading" @click="getData(page)"></v-btn>
    </v-toolbar>
    <create-element api-address="coefficient" @created="getData(1)"></create-element>
    <v-sheet class="bg-amber h-100">
        <datatables :items="items.data"
                    :headers="header"
                    :loading="isLoading"
                    :headers-append="action_header"
                    :headers-prepend="[
                        {key:'row',title:'ردیف'},
                    ]"
                    :total="items.total"
                    :page="page"
                    :perPage="perPage"
                    @update:page="getData"
        >
            <template #row="{index}">
                <td>{{ (index+1)+((page-1)*perPage) }}</td>
            </template>
            <template #news="{item}">
                <td>{{item.news.title}}</td>
            </template>
            <template #actions="{item}">
                <td>
                    <v-btn-group density="compact">
                        <v-btn @click="item.edit=!item.edit;item.show=false;item.deleteShow=false" icon="mdi-pencil"></v-btn>
                        <v-btn @click="item.show=!item.show;item.edit=false;item.deleteShow=false" icon="mdi-badge-account-outline"></v-btn>
                        <v-btn @click="item.deleteShow=!item.deleteShow;item.edit=false;item.show=false" icon="mdi-trash-can-outline" class="text-error" size="small"></v-btn>
                    </v-btn-group>
                </td>
            </template>
            <template #underRow="{item,colspan}">
                <transition-group
                    mode="in-out"
                    enter-active-class="animate__animated animate__bounceInRight"
                    leave-active-class="animate__animated animate__bounceOutRight"
                >
                <tr v-if="item.deleteShow">
                    <td :colspan="colspan">
                        <delete-element url-api="coefficient" :item="item" @deleted="getData(page.value)"></delete-element>
                    </td>
                </tr>
                <tr v-if="item.show">
                    <td :colspan="colspan">
                        <user-info :item="item"></user-info>
                    </td>
                </tr>
                <tr v-if="item?.edit">
                    <td :colspan="colspan">
                        <edit-page url-api="coefficient" :item="item" @updated="getData(1)"></edit-page>
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
import {useApi} from '@/compositions/CallApi.vue';
import userInfo from "./components/userInformation.vue";
import EditPage from "./components/edit.vue";
import CreateElement from './components/create.vue';
import DeleteElement from './components/delete.vue';

const api = useApi();
const isLoading = ref(false);
const header = reactive([
    {title: 'نام', key: 'name'},
    {title: 'عنوان', key: 'title'},
    {title: 'ضریب', key: 'coefficient'},
]);
const action_header = reactive([
    {title: 'نوع خبر', key: 'news'},
    {title: 'عملیات', key: 'actions'},
]);
const items = ref([]);
const page = ref(1);
const dialogShow = ref(false);
const perPage = ref(10);
function getData(event=1){
    page.value = event;
    isLoading.value = true;
    api.post(`coefficient?coefficient-page=${page.value}`)
        .then(response => {
            items.value = response.data;
        })
    .finally(()=>{
        isLoading.value = false;
    })
    ;
}

onMounted(()=>{
    getData();
})
</script>

<style scoped>

</style>
