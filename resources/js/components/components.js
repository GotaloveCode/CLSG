import * as Vue from "vue";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import {ValidationObserver, ValidationProvider, extend } from 'vee-validate';
import {required,email,numeric,min}  from "vee-validate/dist/rules";

import VueToastr from "vue-toastr";
import VueNumeric from 'vue-numeric';
import VueSweetalert2 from 'vue-sweetalert2';

extend("required", required);
extend("email", email);
extend("numeric", numeric);
extend("min", min);

// localize('en', en);
Vue.component('ValidationObserver', ValidationObserver);
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('v-select',  vSelect);
Vue.use(VueSweetalert2,{
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674'
});
Vue.use(VueToastr, {
    /* OverWrite Plugin Options if you need */
});
Vue.use(VueNumeric);
Vue.component('eoi-form', require('./eoi/EoiForm.vue').default);
Vue.component('attachment-form', require('./eoi/AttachmentForm.vue').default);
Vue.component('eoi-service-form', require('./eoi/EoiServiceForm.vue').default);
Vue.component('manage-attachments', require('./eoi/ManageAttachments.vue').default);
