window.Vue = require('vue')
import Vuetify from 'vuetify';
import '@mdi/font/css/materialdesignicons.css'

Vue.use(Vuetify);

require('./bootstrap');

import "./components/components";

window.axios = require('axios')
axios.defaults.baseURL =url+'/api/';

const EoiForm = () => import('./components/eoi/EoiForm.vue' /* webpackChunkName: "js/components/eoi/eoi-form" */);
const AttachmentForm = () => import('./components/eoi/AttachmentForm.vue' /* webpackChunkName: "js/components/eoi/attachment-form" */);
const Modal = () => import('./components/Modal.vue' /* webpackChunkName: "js/components/modal" */);
const ManageReview = () => import('./components/eoi/ManageReview' /* webpackChunkName: "js/components/eoi/manage-review" */);
const ReviewForm = () => import('./components/eoi/CommentForm' /* webpackChunkName: "js/components/eoi/review-form" */);
const EoiList = () => import('./components/eoi/EoiList' /* webpackChunkName: "js/components/eoi/review-form" */);

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    components: {
        EoiForm,
        AttachmentForm,
        Modal,
        ManageReview,
        ReviewForm,
        EoiList
    },
});
