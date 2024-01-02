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
        'appName':decodeURI('%D8%B3%D8%A7%D9%85%D8%A7%D9%86%D9%87%20%D8%A7%D8%B1%D8%B2%DB%8C%D8%A7%D8%A8%DB%8C%20%D8%AE%D8%A8%D8%B1%20%D8%A7%D8%AF%D8%A7%D8%B1%D9%87%20%DA%A9%D9%84%20%D8%AD%D8%B1%D8%A7%D8%B3%D8%AA'),
        'organ':decodeURI('%D9%85%D8%B9%D8%A7%D9%88%D9%86%D8%AA%20%D9%BE%D8%B1%D8%B3%D9%86%D9%84%DB%8C'),
        'logo':'/storage/images/download.jfif',
        'addressApi':'api/'
    })
    .mount("#app")
