<template>
<v-row>
    <v-col cols="12" md="4" offset-md="4" sm="6" offset-sm="3">
        <v-card>
            <v-card-text>
                <v-row>
                    <v-col>
                        <v-text-field
                            :clearable="false"
                            :error-messages="messagesErr.current_password"
                            label="رمز عبور قبلی" v-model="pass.current_password" prepend-icon="mdi-lock"
                            :type="show.current_password?'password':'text'"
                            @click:append="show.current_password=!show.current_password"
                            :append-icon="show.current_password?'mdi-eye':'mdi-eye-off'"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-text-field
                            :clearable="false"
                            :type="show.password?'password':'text'"
                            @click:append="show.password=!show.password"
                            :append-icon="show.password?'mdi-eye':'mdi-eye-off'"
                            label="رمز عبور جدید" v-model="pass.password" prepend-icon="mdi-lock">                </v-text-field>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col>
                        <v-text-field
                            :clearable="false"
                            :type="show.password_confirmation?'password':'text'"
                            @click:append="show.password_confirmation=!show.password_confirmation"
                            :append-icon="show.password_confirmation?'mdi-eye':'mdi-eye-off'"
                            label="تایید رمز عبور جدید" v-model="pass.password_confirmation"
                            prepend-icon="mdi-lock"></v-text-field>
                    </v-col>
                </v-row>
            </v-card-text>
            <v-card-text>
                <template v-for="errs in messagesErr">
                    <v-alert v-for="item in errs" color="error" variant="tonal" density="compact" position="static">
                        {{ item }}
                    </v-alert>
                </template>
            <template v-for="item in messagesSuccess">
                    <v-alert color="success" variant="flat" density="comfortable" position="static">
                        {{ item }}
                    </v-alert>
                </template>
            </v-card-text>
            <v-card-actions>
                <v-btn :loading="loading" prepend-icon="mdi-pencil" variant="flat" color="green" @click="changePass">تغییر رمز عبور</v-btn>
            </v-card-actions>
        </v-card>
    </v-col>
</v-row>
</template>

<script setup>
import {reactive, ref} from "vue";
import {useApi} from '@/compositions/CallApi.vue';

const api = useApi();
const show=reactive({
    current_password:true,
    password:true,
    password_confirmation:true,
})
const pass=reactive({
    current_password:'',
    password:'',
    password_confirmation:'',
})
const messagesErr = ref([]);
const messagesSuccess = ref([]);
const loading = ref(false);

function changePass(){
    loading.value = true;
    api.post('user/change-password',pass)
        .then(response=>{
            if (response.status == 200) {
                messagesErr.value = [];
                messagesSuccess.value = [
                    'ویرایش با موفقیت انجام شد.'
                ];
            }
        })
        .catch(errors=>{
            messagesErr.value=errors.response.data.errors
        })
        .finally(()=>{
            loading.value = false;

        })
}
</script>

<style scoped>

</style>
