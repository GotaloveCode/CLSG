<template>
    <div>
        <div v-html="$error.handle(error)"></div>
        <form @submit.prevent="postData()">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Month</label>
                                <v-select label="name" placeholder="Select Month"
                                          v-model="form.month" :reduce="c => c.no" :options="mths">
                                </v-select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Year</label>
                                <input class="form-control" disabled v-model="form.year">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" v-for="cus in customers" style="margin-top: -10px">
                    <div class="card" style="height: 92%">
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
            <div class="form-group text-center">
                <button class="btn btn-warning" v-if="loading" type="button">Sending ... <i
                    class="feather icon-loader"></i></button>
                <button type="submit" v-else class="btn btn-primary">
                    Submit <i class="feather icon-send"></i>
                </button>
            </div>
        </form>
    </div>
</template>


<script>
import moment from "moment";
import months from "../months";

export default {
    props: {
        checklists: {type: Array},
        checklist_item: {type: [Object, Array]}
    },
    data() {
        return {
            error: '',
            mths: [],
            form: {
                month: moment().month(),
                year: moment().year(),
                customer: [],
                customer_comment: []
            },
            customer_data: [],
            loading: false,
            customers: {}
        }
    },
    created() {
        this.setUp();
    },
    methods: {
        setUp() {
            let allowed = [moment().month()];
            if (moment().date() <= 5) {
                allowed.push(moment().month() - 1);
                this.form.month = moment().month() - 1;
            }
            this.mths = months.filter(x => allowed.includes(x.no));
            this.customers = this.checklists.filter(e => e.type === "Vulnerable Customers");
            if (this.checklist_item.id != undefined) {
                this.form.year = this.checklist_item.year;
                for (let i = 0; i < this.checklist_item.customer_details.length; i++) {
                    this.form.customer[i] = this.checklist_item.customer_details[i].status;
                    this.form.customer_comment[i] = this.checklist_item.customer_details[i].comment;
                }
            }
        },
        postData() {
            let customers = this.validateCustomers();
            if (customers == "comment_required") return this.$toastr.e("Comments are required for In Progress/Not Started Vulnerable Customers Checklist!");
            if (!customers) return this.$toastr.e("All Vulnerable Customers Checklist fields are required!");
            let data = {
                month: this.form.month,
                year: this.form.year,
                customer_details: this.customer_data
            };
            this.error = '';
            this.loading = true;

            axios.post("/vulnerable-customer", data).then(() => {
                window.location.href = "/vulnerable-customer"
            }).catch(error => {
                this.error = error.response;
            });

        },
        validateCustomers() {
            this.customer_data = [];
            let status = true;

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

            this.customer_data.forEach(e => {
                if (e.status != "Completed" && e.comment === "") {
                    status = false;
                    return;
                }
            })

            if (!status) return "comment_required";

            return true;
        }
    }
}
</script>
