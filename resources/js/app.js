import * as Vue from "vue";

require('./bootstrap');
window.Vue = require('vue');
import "./components/components";

const EoiForm = () => import('./components/eoi/EoiForm.vue' /* webpackChunkName: "js/components/eoi/eoi-form" */);
const AttachmentForm = () => import('./components/eoi/AttachmentForm.vue' /* webpackChunkName: "js/components/eoi/attachment-form" */);
const Modal = () => import('./components/Modal.vue' /* webpackChunkName: "js/components/modal" */);
const ManageReview = () => import('./components/eoi/ManageReview' /* webpackChunkName: "js/components/eoi/manage-review" */);
const ReviewForm = () => import('./components/eoi/CommentForm' /* webpackChunkName: "js/components/eoi/review-form" */);

const app = new Vue({
    el: '#app',
    components: {
        EoiForm,
        AttachmentForm,
        Modal,
        ManageReview,
        ReviewForm
    },
});
