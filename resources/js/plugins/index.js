import vuetify from "./vuetify";
import { loadFonts } from './webfontloader'
import {createPinia} from "pinia/dist/pinia";
import colors from 'vuetify/lib/util/colors'
import Vue3PersianDatetimePicker from "vue3-persian-datetime-picker";
import {useApi} from '../compositions/CallApi.vue';
const pinia = createPinia();


export default async function registerPlugin(app){
    loadFonts()
    app.use(vuetify)
        .use(pinia)
        .use(useApi)
        .use(Vue3PersianDatetimePicker,{
            name:'PDatePicker',
            props:{
                format: 'YYYY-MM-DD',
                displayFormat: 'jYYYY-jMM-jDD',
                editable: false,
                inputClass: 'v-field__input',
                placeholder: 'انتخاب تاریخ',
                altFormat: 'YYYY-MM-DD',
                color: colors.green.darken1,
                autoSubmit: false,
            }
        });
}
