import * as Vue from "vue";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import {ValidationObserver, ValidationProvider, extend, localize} from 'vee-validate';
import {required, email, numeric, min_value, max_value,is} from "vee-validate/dist/rules";
import en from 'vee-validate/dist/locale/en.json';

import VueToastr from "vue-toastr";
import VueNumeric from 'vue-numeric';
import VueSweetalert2 from 'vue-sweetalert2';

extend("required", required);
extend("email", email);
extend("numeric", numeric);
extend("min_value", min_value);
extend("max_value", max_value);

localize('en', en);
Vue.component('ValidationObserver', ValidationObserver);
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('v-select', vSelect);
Vue.use(VueSweetalert2, {
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674'
});
Vue.use(VueToastr, {
    /* OverWrite Plugin Options if you need */
});
Vue.use(VueNumeric);

// const EoiForm = () => import('./eoi/EoiForm.vue' /* webpackChunkName: "js/components/eoi/eoi-form" */);
// Vue.component('attachment-form', require('./eoi/AttachmentForm.vue').default);
Vue.component('eoi-service-form', require('./eoi/EoiServiceForm.vue').default);
Vue.component('manage-attachments', require('./eoi/ManageAttachments.vue').default);
