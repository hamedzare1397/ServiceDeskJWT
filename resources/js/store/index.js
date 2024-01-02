import {defineStore} from 'pinia'
import {ref} from "vue";

export const useAppStore = defineStore('app', () => {
    const showRightNav = ref(false);
    const showRailNav = ref(false);
    const showFooter = ref(true);
    const expandNav = ref(true);
    const showLeftNav = ref(false);
    return {
        //functions

        //variables
        showRightNav,showRailNav,showFooter,expandNav,
        showLeftNav
    }
});
