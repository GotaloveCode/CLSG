import Vue from "vue";
import Vuex from "vuex";

import eoi from "./eoi";
import checklist from "./checklist";
Vue.use(Vuex);


export default new Vuex.Store({
    modules:{
       eoi,
       checklist
    },
    state:{},
    mutations:{},
    ations:{}
})
