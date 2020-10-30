import * as Vue from "vue";
import store from "./store/store";


require('./bootstrap');
window.Vue = require('vue');
window.eventBus = new Vue();

import "./components/components";

const EoiForm = () => import('./components/eoi/EoiForm' /* webpackChunkName: "js/components/eoi/eoi-form" */);
const ManageAttachments= () => import('./components/eoi/ManageAttachments' /* webpackChunkName: "js/components/eoi/manage-attachments" */);
const AttachmentForm = () => import('./components/eoi/AttachmentForm' /* webpackChunkName: "js/components/eoi/attachment-form" */);
const Modal = () => import('./components/Modal.vue' /* webpackChunkName: "js/components/modal" */);
const ManageReview = () => import('./components/ManageReview' /* webpackChunkName: "js/components/manage-review" */);
const ReviewForm = () => import('./components/CommentForm' /* webpackChunkName: "js/components/eoi/review-form" */);
const BcpForm = () => import('./components/bcp/BcpForm' /* webpackChunkName: "js/components/bcp/bcp-form" */);
const MgmForm = () => import('./components/bcp/MgmForm' /* webpackChunkName: "js/components/bcp/mgm-form" */);
const NotificationComponent = () => import('./components/NotificationComponent' /* webpackChunkName: "js/components/notification-component" */);
const ErpForm = () => import('./components/erp/ErpForm.vue' /* webpackChunkName: "js/components/erp/erp-form" */);
const StaffForm = () => import('./components/staff/Create.vue' /* webpackChunkName: "js/components/staff/create" */);
const ManageStaff= () => import('./components/staff/ManageStaff' /* webpackChunkName: "js/components/staff/manage-staff" */);
const ChecklistForm = () => import('./components/checklist/ChecklistForm' /* webpackChunkName: "js/components/checklist/checklist-form" */);
const VerificationForm = () => import('./components/verification/VerificationForm' /* webpackChunkName: "js/components/verification/verification-form" */);
const ShowVerification = () => import('./components/verification/ShowVerification' /* webpackChunkName: "js/components/verification/show-verification" */);
const ShowChecklist = () => import('./components/checklist/ShowChecklist' /* webpackChunkName: "js/components/checklist/show-checklist" */);
const EssentialOperation = () => import('./components/checklist/EssentialOperation' /* webpackChunkName: "js/components/checklist/essential-operation" */);
const ViewEssentialOperation = () => import('./components/checklist/ViewEssentialOperation' /* webpackChunkName: "js/components/checklist/view-essential-operation" */);
const VulnerableCustomer = () => import('./components/checklist/VulnerableCustomer' /* webpackChunkName: "js/components/checklist/vulnerable-customer" */);
const ViewVulnerableCustomer = () => import('./components/checklist/ViewVulnerableCustomer' /* webpackChunkName: "js/components/checklist/view-vulnerable-customer" */);
const WspReporting = () => import('./components/checklist/WspReporting' /* webpackChunkName: "js/components/checklist/wsps-reporting" */);
const ViewWspReporting = () => import('./components/checklist/ViewWspReporting' /* webpackChunkName: "js/components/checklist/view-wsps-reporting" */);
const CslgCalculation = () => import('./components/checklist/CslgCalculation' /* webpackChunkName: "js/components/checklists/cslg-calculation" */);
const ViewCslgCalculation = () => import('./components/checklist/ViewCslgCalculation' /* webpackChunkName: "js/components/checklists/view-cslg-calculation" */);
const FormatForm = () => import('./components/reportFormat/FormatForm' /* webpackChunkName: "js/components/reportFormat/format-form" */);
const ShowFormat = () => import('./components/reportFormat/ShowFormat' /* webpackChunkName: "js/components/reportFormat/show-format" */);


const app = new Vue({
    el: '#app',
    store,
    components: {
        EoiForm,
        AttachmentForm,
        Modal,
        ManageReview,
        ReviewForm,
        BcpForm,
        MgmForm,
        ErpForm,
        StaffForm,
        ManageStaff,
        ChecklistForm,
        ManageAttachments,
        NotificationComponent,
        VerificationForm,
        ShowVerification,
        ShowChecklist,
        FormatForm,
        ShowFormat,
        ViewEssentialOperation,
        EssentialOperation,
        VulnerableCustomer,
        ViewVulnerableCustomer,
        WspReporting,
        ViewWspReporting,
        CslgCalculation,
        ViewCslgCalculation
    },
});
