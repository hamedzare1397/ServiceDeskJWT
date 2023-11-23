import './bootstrap';
import registerPlugins from './plugins'

import {createApp} from 'vue'
import 'vuetify/styles'
import routes from "./router";
import App from './App.vue'
const app=createApp(App)
registerPlugins(app);
import './axios/config';
app
    .use(routes)
    .provide('config',{
        'appName':'سامانه ارزیابی خبر',
        'organ':'اداره زیر ساخت مخابرات استان فارس',
        'logo':'/storage/images/favicon.ico',
        'addressApi':'http://127.0.0.1:8000/api'
    })
    .mount("#app")
