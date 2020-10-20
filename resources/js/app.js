import * as Vue from "vue";
import store from "./store/store";
import Vuetify from "vuetify";

require('./bootstrap');
window.Vue = require('vue');
Vue.use(Vuetify);

import "./components/components";

const EoiForm = () => import('./components/eoi/EoiForm.vue' /* webpackChunkName: "js/components/eoi/eoi-form" */);
const EoiList = () => import('./components/eoi/EoiList.vue' /* webpackChunkName: "js/components/eoi/eoi-list" */);
const AttachmentForm = () => import('./components/eoi/AttachmentForm.vue' /* webpackChunkName: "js/components/eoi/attachment-form" */);
const Modal = () => import('./components/Modal.vue' /* webpackChunkName: "js/components/modal" */);
const ManageReview = () => import('./components/eoi/ManageReview' /* webpackChunkName: "js/components/eoi/manage-review" */);
const ReviewForm = () => import('./components/eoi/CommentForm' /* webpackChunkName: "js/components/eoi/review-form" */);
const BcpForm = () => import('./components/bcp/BcpForm' /* webpackChunkName: "js/components/bcp/bcp-form" */);
const BcpList = () => import('./components/bcp/BcpList' /* webpackChunkName: "js/components/bcp/bcp-list" */);
const ErpForm = () => import('./components/erp/ErpForm.vue' /* webpackChunkName: "js/components/erp/erp-form" */);


const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    store,
    components: {
        EoiForm,
        AttachmentForm,
        Modal,
        ManageReview,
        ReviewForm,
        EoiList,
        BcpForm,
        BcpList,
        ErpForm
    },
});
