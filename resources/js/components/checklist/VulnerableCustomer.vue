<template>
    <div>
        <div v-html="$error.handle(error)"/>
        <template v-if="show">
            <view-vulnerable-customer :checklist="checklist_item"  :customers="customers" :staff="staff"></view-vulnerable-customer>
        </template>
        <div v-if="!show">
            <form @submit.prevent="postData()">
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
import ViewVulnerableCustomer from "./ViewVulnerableCustomer";

export default {
    props:{
        checklists:{type:Array},
        checklist_item:{type: [Object, Array]}
    },
    data() {
        return {
            error: '',
            form: {
                customer: [],
                staff: [],
                customer_comment: [],
                staff_comment: []
            },
            customer_data: [],
            staff_data: [],
            loading: false,
            show: false,
            customers:{},
            staff:{}
        }
    },
    created() {
        this.setUp();
    },
    methods: {
        setUp(){
            this.customers = this.checklists.filter(e => e.type ==="Vulnerable Customers");
            this.staff = this.checklists.filter(e => e.type ==="Staff Health Protection");
                 if (this.checklist_item.id !=undefined){
                this.show = true;
            }
        },
        postData() {
            if (!this.validateStaff()) return this.$toastr.e("All Staff Health Protection Checklist fields are required!");
            if (!this.validateCustomers()) return this.$toastr.e("All Vulnerable Customers Checklist fields are required!");
               let data = {
                   customer_details: this.customer_data,
                   staff_details: this.staff_data
            };
            this.error = '';
            this.loading = true;
            axios.post("/reports/vulnerable-customer", data).then(() => {
                window.location.href = "/reports/vulnerable-customer-list"
            }).catch(error => {
                this.error = error.response;
            });

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
        }
    },
    components: {
        ViewVulnerableCustomer
    }
}
</script>
