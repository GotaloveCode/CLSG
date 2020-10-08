import * as Vue from "vue";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import {ValidationObserver, ValidationProvider, extend } from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';
import VueToastr from "vue-toastr";

Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule]);
});
// localize('en', en);
Vue.component('ValidationObserver', ValidationObserver);
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('v-select',  vSelect);
Vue.use(VueToastr, {
    /* OverWrite Plugin Options if you need */
});

Vue.component('eoi-form', require('./eoi/EoiForm.vue').default);
Vue.component('eoi-service-form', require('./eoi/EoiServiceForm.vue').default);

