import Vue from "vue";
import Vuex from "vuex";

import eoi from "./eoi";
import checklist from "./checklist";
import verification from "./verification";
import report_format from "./report_format";
Vue.use(Vuex);


export default new Vuex.Store({
    modules:{
       eoi,
       checklist,
       verification,
       report_format
    },
    state:{},
    mutations:{},
    ations:{}
})
