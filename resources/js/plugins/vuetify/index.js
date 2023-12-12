
import { createVuetify } from 'vuetify'
import {md3} from 'vuetify/blueprints'
import { VBtn,VRadio,VCheckbox } from 'vuetify/components'
import colors from 'vuetify/lib/util/colors'

export default createVuetify({
    blueprint: md3,
    // ssr: true,
    defaults: {
        VSelect:{
            noDataText:'بدون مقدار اولیه'
        },
        VRadio:{
            trueIcon:"mdi-checkbox-marked-circle-outline",
        },
        VCheckbox:{
            trueIcon:"mdi-checkbox-marked-outline",
        },
        VBtnEdit:{
            color: 'success',
            variant:"outlined",
            prependIcon:'mdi-pencil'
        },
        VBtnClose:{
            color: 'error',
            icon:'mdi-close',
            density: 'compact',
            size:'small',
        },
       VBtnCreate:{
            color: 'primary',
            variant:'outlined'
        },
        VBtnRemove:{
            color: 'error',
            variant:'outlined'
        },
        VTextField:{
            density:'compact',
            clearable:true,
        },
        VProgressLinear:{
            color:'primary'
        }
    },
    locale:{
        locale: 'fa',
        rtl:{fa:true},
    },
    aliases: {
        VBtnEdit: VBtn,
        VBtnCreate: VBtn,
        VBtnRemove: VBtn,
        VBtnClose: VBtn,
    },
    theme: {
        defaultTheme:'light',
        themes: {
            light: {
                dark: false,
                colors:{
                    primary:colors.green.darken1,
                    secondary: colors.green.darken4,
                }
            },
            dark: {
                dark: true,
                colors:{
                    primary:colors.green.darken1,
                    secondary: colors.green.darken4,
                }
            },
        },
    },
  })
