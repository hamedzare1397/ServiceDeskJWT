import { loadFonts } from './webfontloader'
import {createPinia} from "pinia";
import vuetify from "./vuetify";

const pinia = createPinia();

export default async function registerPlugin(app){
    loadFonts();
    app.use(vuetify)
        .use(pinia);
}
