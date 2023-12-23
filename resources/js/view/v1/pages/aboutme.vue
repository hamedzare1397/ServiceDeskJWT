<template>
<div class=" h-100 d-flex justify-center align-center">
    <v-card class="h-50 bg-deep-purple w-md-25">
        <v-card-title>
            <v-img :src="logo" cover></v-img>
        </v-card-title>
        <v-card-text class="text-center">
            <h2>{{decodeURI('%20%D8%A7%D8%AF%D8%A7%D8%B1%D9%87%20%D8%B2%DB%8C%D8%B1%D8%B3%D8%A7%D8%AE%D8%AA%20%D9%85%D8%AE%D8%A7%D8%A8%D8%B1%D8%A7%D8%AA%20%D9%81%D8%A7%D8%B1%D8%B3')}}</h2>
            <h7>{{ decodeURI('%D9%BE%DB%8C%D8%A7%D8%AF%D9%87%20%D8%B3%D8%A7%D8%B2%DB%8C%20%D8%AA%D9%88%D8%B3%D8%B7')}}</h7>
            <h4 class="font-weight-bold">{{ decodeURI('%D9%85%D9%87%D9%86%D8%AF%D8%B3%20%D8%AD%D8%A7%D9%85%D8%AF%20%D8%B2%D8%A7%D8%B1%D8%B9')}}</h4>
        </v-card-text>
    </v-card>
</div>
</template>

<script setup>
import {inject} from "vue";

const logo=inject('config').logo
</script>

<style scoped>

</style>
