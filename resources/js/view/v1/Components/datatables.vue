<template>
    <div v-if="ShowType==='datatable'">
        <v-table density="compact" :id="TableName">
            <caption>
                <slot name="caption"></slot>
                <v-progress-linear
                    v-show="loading"
                    indeterminate
                ></v-progress-linear>
            </caption>
            <thead>
            <tr class="pa-0" v-if="loadingType=='linear'">
                <th :colspan="headers.length+headersPrepend.length+headersAppend.length">
                    <v-pagination
                        v-model="page"
                        :density="density"
                        :length="Math.ceil(total/perPage)"
                        :total-visible="TotalVisible"
                        @update:modelValue="updatePaginate"
                    ></v-pagination>
                </th>
            </tr>
            <tr>
                <th v-for="item in headersPrepend">{{ item.title}}</th>
                <th v-for="item in headers">{{ item.title}}</th>
                <th v-for="item in headersAppend">{{ item.title}}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item,index) in items" v-key="item.key">

                <td v-for="col in headersPrepend" v-key="col.key" :index="index">
                    <slot :name="col.key" :item="item" :col="col" :index="index"></slot>
                </td>
                <td v-for="col in headers" v-key="col.key" :index="index">{{ item[col.key]}}</td>
                <td v-for="col in headersAppend" v-key="col.key" :index="index">
                    <slot :name="col.key" :item="item" :col="col"></slot>
                </td>
            </tr>
            </tbody>
            <tfoot>
            <slot name="footer"></slot>
            </tfoot>
        </v-table>
        <v-overlay
            v-if="loadingType==='circle'"
            v-model="dataLoading"
            contained
            class="align-center justify-center">
            <slot name="overloading">
                <h1>در حال بارگذاری داده ها</h1>
            </slot>
        </v-overlay>
    </div>
    <template v-if="ShowType==='card'">
        <v-card v-for="(index,item) in items" v-key="item.id">
            اشئثی
        </v-card>
    </template>
</template>

<script setup>
import {ref, defineProps, watch, reactive, defineEmits} from 'vue';
const props=defineProps({
    ShowType:{
        default:'datatable',
        type:String
    },
    TableName:{
        default:'table',
        type:String,
    },
    headersAppend:{
        default:[],
        type:Array,
    },
    headersPrepend:{
        default:[],
        type:Array,
    },
    loadingType:{
        type:String,
        default:'linear',
        validator(value) {
            // The value must match one of these strings
            return ['circle', 'linear'].includes(value)
        }
    },
    loading:{
        type:Boolean,
        default:false,
    },
    TotalVisible:{
        type:Number,
        default: 5,
    },
    density:{
        type:String,
        default:'compact'
    },
    headers:{
        type:Array
    },
    items:{
        type:Array
    },
    page:{
        type:Number
    },
    perPage:{
        type:Number
    },
    total:{
        required:true
    }
});
const emits=defineEmits(['update:page'])
const page= ref(props.page);
const ShowType=ref(props.ShowType)
const dataLoading = ref(props.loading);
function updatePaginate(event){
    console.log(event);
    emits('update:page', event);
}
watch(()=>props.page, (newVal,oldValue) => {
    return page.value = newVal;
});
watch(()=>props.loading , (newVal,oldValue) => {
    return dataLoading.value = newVal;
});
</script>

<style scoped>

</style>
