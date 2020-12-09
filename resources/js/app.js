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
const ManagePerformanceReview = () => import('./components/checklist/ManagePerformanceReview' /* webpackChunkName: "js/components/checklist/manage-performance-review" */);
const ReviewForm = () => import('./components/CommentForm' /* webpackChunkName: "js/components/eoi/review-form" */);
const BcpForm = () => import('./components/bcp/BcpForm' /* webpackChunkName: "js/components/bcp/bcp-form" */);
const MgmForm = () => import('./components/bcp/MgmForm' /* webpackChunkName: "js/components/bcp/mgm-form" */);
const NotificationComponent = () => import('./components/NotificationComponent' /* webpackChunkName: "js/components/notification-component" */);
const ErpForm = () => import('./components/erp/ErpForm.vue' /* webpackChunkName: "js/components/erp/erp-form" */);
const StaffForm = () => import('./components/staff/Create.vue' /* webpackChunkName: "js/components/staff/create" */);
const ManageStaff= () => import('./components/staff/ManageStaff' /* webpackChunkName: "js/components/staff/manage-staff" */);
const EssentialOperation = () => import('./components/checklist/EssentialOperation' /* webpackChunkName: "js/components/checklist/essential-operation" */);
const VulnerableCustomer = () => import('./components/checklist/VulnerableCustomer' /* webpackChunkName: "js/components/checklist/vulnerable-customer" */);
const WspReporting = () => import('./components/checklist/WspReporting' /* webpackChunkName: "js/components/checklist/wsps-reporting" */);
const CslgCalculation = () => import('./components/checklist/CslgCalculation' /* webpackChunkName: "js/components/checklists/cslg-calculation" */);
const ViewCslgCalculation = () => import('./components/checklist/ViewCslgCalculation' /* webpackChunkName: "js/components/checklists/view-cslg-calculation" */);
const ApproveClgCalculation = () => import('./components/checklist/ApproveClgCalculation' /* webpackChunkName: "js/components/checklists/approve-cslg-calculation" */);
const StaffHealth = () => import('./components/checklist/StaffHealth' /* webpackChunkName: "js/components/checklists/staff-health" */);
const PerformanceCard = () => import('./components/checklist/PerformanceCard' /* webpackChunkName: "js/components/reportFormat/performance-card" */);
const ViewPerformanceCard = () => import('./components/checklist/ViewPerformanceCard' /* webpackChunkName: "js/components/reportFormat/view-performance-card" */);
const FileUpload = () => import('./components/FileUpload' /* webpackChunkName: "js/components/file-upload" */);
const ManageRole = () => import('./components/ManageRole' /* webpackChunkName: "js/components/manage-role" */);


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
        FileUpload,
        MgmForm,
        ErpForm,
        StaffForm,
        ManageStaff,
        ManageAttachments,
        NotificationComponent,
        EssentialOperation,
        VulnerableCustomer,
        WspReporting,
        CslgCalculation,
        ViewCslgCalculation,
        StaffHealth,
        PerformanceCard,
        ViewPerformanceCard,
        ApproveClgCalculation,
        ManagePerformanceReview,
        ManageRole
    },
});
