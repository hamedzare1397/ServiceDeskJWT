<template>
    <v-card>
        <v-card-title class="bg-secondary w-25 rounded-e-circle">{{item.firstname}} {{item.lastname}}</v-card-title>
        <v-card-text>
            <v-row>
                <v-col cols="12" md="6">
                    <v-list>
                        <v-list-item>
                            <v-list-item-title>شماره همراه:</v-list-item-title>
                            <v-label>{{ item.phone }}</v-label>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>پست الکترونیکی:</v-list-item-title>
                            <v-label>{{ item.email }}</v-label>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>پست الکترونیکی:</v-list-item-title>
                            <v-label>{{ item.email }}</v-label>
                        </v-list-item>
                    </v-list>
                </v-col>
                <v-col cols="12" md="6">
                    <v-list>
                        <v-list-item>
                            <v-list-item-title>شماره همراه:</v-list-item-title>
                            <v-label>{{ item.phone }}</v-label>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>پست الکترونیکی:</v-list-item-title>
                            <v-label>{{ item.email }}</v-label>
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
