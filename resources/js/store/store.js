import Vue from "vue";
import Vuex from "vuex";

import eoi from "./eoi";
import checklist from "./checklist";
import verification from "./verification";

Vue.use(Vuex);


export default new Vuex.Store({
    modules:{
       eoi,
       checklist,
       verification
    },
    state:{},
    mutations:{},
    ations:{}
})
