<template>
    <v-card>

        <v-card-text>
            <v-row class="bg-amber rounded-shaped">
                <v-col cols="12"><v-card-title class="rounded-pill text-center">{{item.firstname}} {{item.lastname}}</v-card-title></v-col>
                <v-col cols="12" sm="6">
                    <v-list class="rounded-shaped  v-card">
                        <v-list-item>
                            <v-list-item-title>کدملی</v-list-item-title>
                            <v-label>{{ item.nativeid }}</v-label>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>شماره همراه:</v-list-item-title>
                            <v-label>{{ item.mobile }}</v-label>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>پست الکترونیکی:</v-list-item-title>
                            <v-label>{{ item.email }}</v-label>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>آدرس</v-list-item-title>
                            <v-label>{{ item.address }}</v-label>
                        </v-list-item>
                    </v-list>
                </v-col>
                <v-col cols="12" sm="6">
                    <v-list  class="rounded-shaped v-card">
                        <v-list-item>
                            <v-list-item-title>تلفن ثابت:</v-list-item-title>
                            <v-label>{{ item.phone }}</v-label>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>کد پستی</v-list-item-title>
                            <v-label>{{ item.zipCode }}</v-label>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>پست الکترونیکی:</v-list-item-title>
                            <v-label>{{ item.email }}</v-label>
                        </v-list-item>
                    </v-list>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</template>

<script setup>
import {computed, defineProps, onMounted, ref} from "vue";

const props=defineProps({
    item:{
        type:Object,
        default:{},
        required:true,
    },
    col:{
        type:Number,
        default: 1,
    }
})
const item = ref(props.item);
const col = ref(props.col);
const title=computed(()=>{
    return item;
    return item.firstname + ' ' + item.lastname;
})

onMounted(()=>{

})
</script>

<style scoped>

</style>
