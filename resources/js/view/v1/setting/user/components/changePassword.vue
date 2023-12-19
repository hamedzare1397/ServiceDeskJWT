<template>
<v-card>
    <v-card-text>
        <v-row>
            <v-col>
                <v-text-field label="رمز عبور قبلی" v-model="pass.old_password" prepend-icon="mdi-lock"></v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-text-field label="رمز عبور جدید" v-model="pass.new_password" prepend-icon="mdi-lock"></v-text-field>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-text-field label="تایید رمز عبور جدید" v-model="pass.confirm_password" prepend-icon="mdi-lock"></v-text-field>
            </v-col>
        </v-row>
    </v-card-text>
</v-card>
</template>

<script>
export default {
    name: "changePassword"
}
</script>

<style scoped>

</style>
