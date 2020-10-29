<template>
    <div>
        <div v-html="$error.handle(error)"/>
        <template v-if="!show">
        </template>
        <template v-if="show">
            <view-checklist :checklist="checklist_item" :essentials="essentials" :customers="customers" :staff="staff" :communication="communication"></view-checklist>
        </template>
        <div v-if="!show">
            <form @submit.prevent="postData()">
                <div class="row">
                    <h4 class="text-uppercase col-md-12 text-center">A. GENERAL </h4>
                    <div class="col-md-4 form-group">
                        <label>Revenues collected this month (KES)</label>
                        <vue-numeric separator="," v-model="revenue" class="form-control" required></vue-numeric>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>O&M costs this month (KES)</label>
                        <vue-numeric separator="," v-model="operations_costs" class="form-control" required></vue-numeric>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Total CLSG amount disbursed to date (KES)</label>
                        <vue-numeric separator="," v-model="clsg_total" class="form-control" required></vue-numeric>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Challenges (if any) encountered during the reporting period and mitigation
                            measures</label>

                        <textarea class="form-control" v-model="challenges"></textarea>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Expected activities for the next month (specifying any planned procurement or
                            contracting)</label>
                        <textarea class="form-control" required v-model="expected_activities"></textarea>
                    </div>
                    <h4 class="text-uppercase col-md-12 text-center">1. Essential Operations </h4>
                    <div class="col-md-6" v-for="essn in essentials" style="margin-top: -10px">
                        <div class="card">
                            <div class="card-header">
                                <p><i class="fa fa-angle-double-right" aria-hidden="true"></i> {{ essn.name }}</p>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body" style="padding-top: 0">
                            <span style="display: flex">
                              <div>
                              <fieldset class="radio">
                                <label>
                                    <input type="radio" value="Completed" v-model="form.essential[essn.id]"
                                           :name="'status_completed'+essn.id">
                                  <b>Completed</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" value="In Progress" v-model="form.essential[essn.id]"
                                           :name="'status_in_progress'+essn.id">
                                    <b>In Progress</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" value="Not Started" v-model="form.essential[essn.id]"
                                           :name="'status_not_started'+essn.id">
                                   <b>Not Started</b>
                                </label>
                            </fieldset>
                              </div>
                                <div style="margin-left: 15%;">
                                   <textarea cols="30" rows="2" class="form-control"
                                             v-model="form.essential_comment[essn.id]"
                                             placeholder="Your comment here"></textarea>
                                </div>

                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-uppercase text-center">2.Vulnerable Customers</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" v-for="cus in customers" style="margin-top: -10px">
                        <div class="card">
                            <div class="card-header">
                                <p><i class="fa fa-angle-double-right" aria-hidden="true"></i> {{ cus.name }}</p>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body" style="padding-top: 0">
                          <span style="display: flex">
                                <div>
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" value="Completed" v-model="form.customer[cus.id]"
                                           :name="'status_completed_1'+cus.id">
                                    <b>Completed</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" value="In Progress" v-model="form.customer[cus.id]"
                                           :name="'status_in_progress_1'+cus.id">
                                    <b>In Progress</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" value="Not Started" v-model="form.customer[cus.id]"
                                           :name="'status_not_started_1'+cus.id">
                                    <b>Not Started</b>
                                </label>
                            </fieldset>
                                </div>
                                 <div style="margin-left: 15%;">
                                   <textarea cols="30" rows="2" class="form-control"
                                             v-model="form.customer_comment[cus.id]"
                                             placeholder="Your comment here"></textarea>
                                </div>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-uppercase text-center">3.Staff Health Protection</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" v-for="stf in staff" style="margin-top: -10px">
                        <div class="card">
                            <div class="card-header">
                                <p><i class="fa fa-angle-double-right" aria-hidden="true"></i> {{ stf.name }}</p>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body" style="padding-top: 0">
                            <span style="display: flex">
                                <div>
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" value="Completed" v-model="form.staff[stf.id]"
                                           :name="'status_completed'+stf.id">
                                    <b>Completed</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" value="In Progress" v-model="form.staff[stf.id]"
                                           :name="'status_in_progress'+stf.id">
                                    <b>In Progress</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" value="Not Started" v-model="form.staff[stf.id]"
                                           :name="'status_not_started'+stf.id">
                                    <b>Not Started</b>
                                </label>
                            </fieldset>
                                </div>
                                  <div style="margin-left: 15%;">
                                   <textarea cols="30" rows="2" class="form-control"
                                             v-model="form.staff_comment[stf.id]"
                                             placeholder="Your comment here"></textarea>
                                </div>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-uppercase text-center">4.Communication</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" v-for="comm in communication" style="margin-top: -10px">
                        <div class="card">
                            <div class="card-header">
                                <p><i class="fa fa-angle-double-right" aria-hidden="true"></i> {{ comm.name }}</p>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body" style="padding-top: 0">
                            <span style="display: flex">
                             <div>
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" value="Completed" v-model="form.communication[comm.id]"
                                           :name="'status_completed'+comm.id">
                                    <b>Completed</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" value="In Progress" v-model="form.communication[comm.id]"
                                           :name="'status_in_progress'+comm.id">
                                    <b>In Progress</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" value="Not Started" v-model="form.communication[comm.id]"
                                           :name="'status_not_started'+comm.id">
                                    <b>Not Started</b>
                                </label>
                            </fieldset>
                             </div>
                                 <div style="margin-left: 15%;">
                                 <textarea cols="30" rows="2" class="form-control"
                                           v-model="form.communication_comment[comm.id]"
                                           placeholder="Your comment here"></textarea>
                               </div>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-warning" v-if="loading" type="button">Sending ... <i
                        class="feather icon-loader"></i></button>
                    <button type="submit" v-else class="btn btn-primary">
                        Submit <i class="feather icon-send"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>


<script>
import ViewChecklist from "./ViewChecklist";

export default {
    props:{
        checklists:{type:Array},
        checklist_item:{type: [Object, Array]}
    },
    data() {
        return {
            error: '',
            form: {
                essential: [],
                customer: [],
                staff: [],
                communication: [],
                essential_comment: [],
                customer_comment: [],
                staff_comment: [],
                communication_comment: [],
            },
            revenue: 0,
            operations_costs: 0,
            clsg_total:0,
            challenges: '',
            expected_activities: '',
            essential_data: [],
            customer_data: [],
            staff_data: [],
            communication_data: [],
            loading: false,
            show: false,
            essentials:{},
            customers:{},
            staff:{},
            communication:{}
        }
    },
    created() {
        this.listen();
        this.setUp();
    },
    methods: {
        setUp(){
            this.essentials = this.checklists.filter(e => e.type ==="Essential Operations");
            this.customers = this.checklists.filter(e => e.type ==="Vulnerable Customers");
            this.staff = this.checklists.filter(e => e.type ==="Staff Health Protection");
            this.communication = this.checklists.filter(e => e.type ==="Communication");

            if (this.checklist_item.id !=undefined){
                this.show = true;
            }
            },
        postData() {
            if (!this.validateCommunication()) return this.$toastr.e("All Communication Checklist fields are required!");
            if (!this.validateStaff()) return this.$toastr.e("All Staff Health Protection Checklist fields are required!");
            if (!this.validateCustomers()) return this.$toastr.e("All Vulnerable Customers Checklist fields are required!");
            if (!this.validateEssentials()) return this.$toastr.e("All Essential Operations Checklist fields are required!");
            let data = {
                challenges: this.challenges,
                expected_activities: this.expected_activities,
                revenue: this.revenue,
                operations_costs:this.operations_costs,
                clsg_total: this.clsg_total,
                essential: this.essential_data,
                customer: this.customer_data,
                staff: this.staff_data,
                communication: this.communication_data
            };
            this.error = '';
            this.loading = true;
            axios.post("/reports/checklist", data).then(() => {
              window.location.href = "/reports/checklist-list"
            }).catch(error => {
                this.error = error.response;
            });

        },
        validateCommunication() {
            this.communication_data = [];
            this.form.communication.forEach((e, v) => {
                this.communication_data.push({id: v, status: e, comment: ""})
            })
            if (this.communication_data.length < 3) {
                return false;
            }

            this.form.communication_comment.forEach((p, q) => {
                for (let i = 0; i < this.communication_data.length; i++) {
                    if (this.communication_data[i]['id'] === q) {
                        this.communication_data[i]['comment'] = p;
                    }
                }
            })
            return true;
        },
        validateStaff() {
            this.staff_data = [];
            this.form.staff.forEach((e, v) => {
                this.staff_data.push({id: v, status: e, comment: ""})
            })
            if (this.staff_data.length < 11) {
                return false;
            }

            this.form.staff_comment.forEach((p, q) => {
                for (let i = 0; i < this.staff_data.length; i++) {
                    if (this.staff_data[i]['id'] === q) {
                        this.staff_data[i]['comment'] = p;
                    }
                }
            })
            return true;
        },
        validateCustomers() {
            this.customer_data = [];
            this.form.customer.forEach((e, v) => {
                this.customer_data.push({id: v, status: e, comment: ""})
            })
            if (this.customer_data.length < 2) {
                return false;
            }

            this.form.customer_comment.forEach((p, q) => {
                for (let i = 0; i < this.customer_data.length; i++) {
                    if (this.customer_data[i]['id'] === q) {
                        this.customer_data[i]['comment'] = p;
                    }
                }
            })
            return true;
        },
        validateEssentials() {
            this.essential_data = [];
            if (this.form.essential.length < 7) {
                return false;
            }
            this.form.essential.forEach((e, v) => {
                this.essential_data.push({id: v, status: e, comment: ""})
            })
            this.form.essential_comment.forEach((p, q) => {
                for (let i = 0; i < this.essential_data.length; i++) {
                    if (this.essential_data[i]['id'] === q) {
                        this.essential_data[i]['comment'] = p;
                    }
                }
            })
            return true;
        },
        listen() {
            eventBus.$on("checklist_form", () => {
                this.show_date_form = false;
                this.show = false;
            })
            eventBus.$on("view_checklist", () => {
                this.show_date_form = false;
                this.show = true;
            })
        }
    },
    components: {
        ViewChecklist
    }
}
</script>
