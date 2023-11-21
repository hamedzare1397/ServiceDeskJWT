<template>
<v-card>
    <v-toolbar density="compact" flat :collapse="collapseToolbar">
        <v-btn
                icon="mdi-refresh"
                @click="getList"
                :loading="refreshLoading"
            ></v-btn>
            <v-btn
                :icon="collapseToolbar?'mdi-pin':'mdi-pin-off'"
                @click="collapseToolbar=!collapseToolbar"
            ></v-btn>
        <div id="toolbar"></div>
    </v-toolbar>
    <v-card-item class="w-100">
        <datatables
            :items="list.data"
            v-model:page="page"
            @update:page="updatePaginate"
            TotalVisible="20"
            :total="list.total"
            :perPage="10"
            :headers="[
                {title:'شماره نامه',key:'en',},
                {title:'کد رهگیری',key:'code',},
            ]"
            :headers-prepend="[
                {key:'index',title:'ردیف'}
            ]"

            :headers-append="[
                {key:'subject',title:'موضوع'},
                {key:'nativeID',title:'کدملی'},
                {key:'action',title:'عملیات'},
                ]"
        >
            <template v-slot:index="{index}">{{(index+1)+((page-1)*10)}}</template>
            <template v-slot:subject="{item,index}">
                {{item.requestJson.subject}}
            </template>
            <template v-slot:nativeID="{item,index}">
                {{item.requestJson.nativID}}
            </template>
            <template v-slot:action="{item,index}">

                    <show-flow :data="{item:item}"></show-flow>

            </template>
        </datatables>
    </v-card-item>
</v-card>
</template>

<script setup>

import {useCartableStore} from "@/store/cartable.js";
import {useFlowStore} from "@/store/flow.js";
import {defineComponent, onMounted, ref,computed} from "vue";
import Datatables from "@/view/v1/Components/datatables.vue";
import ShowFlow from "@/view/v1/Components/ShowFlow.vue";

const showd = ref(false);
const cartableStore=useCartableStore();
const flowStore = useFlowStore();
const list = ref([]);
const refreshLoading = ref(false);
const collapseToolbar = ref(true);
const page = ref(1);


function updatePaginate(event){
    getList();
}
function getList(){
    refreshLoading.value = true;
    let str='';
    if (page.value>1){
        str += `page=${page.value}&`;
    }
    cartableStore.getList(`sends?${str}`)
        .then(response=>{
            list.value = response.data;
        })
        .catch(errors=>{
            alert('error')
        })
        .finally(()=>{
            refreshLoading.value = false;
        })
}


onMounted(()=>{
    getList();
})

</script>

<style scoped>

</style>
