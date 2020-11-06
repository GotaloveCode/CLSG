<template>
    <div>
        <div v-html="$error.handle(error)"></div>
        <form @submit.prevent="postData()">
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
                <div class="col-md-12 form-group">
                    <div class="card" style="height: 92%">
                        <div class="card-header">
                            <p>Status of implementation of COVID-19 emergency interventions (both physical and
                                financial progress)</p>
                        </div>
                        <div class="card-content">
                            <div class="card-body" style="padding-top: 0">
                                <table style="width: 100%">
                                    <tr>
                                        <th width="20%">Service</th>
                                        <th><span class="ml-10">Description</span></th>
                                        <th>Cost</th>
                                        <th></th>
                                    </tr>
                                    <tr v-for="(item,k) in form.status_of_covid_implementation" :key="k">
                                        <td>
                                            <v-select label="name" placeholder="Select Service"
                                                      v-model="item.service" :reduce="s => s.id"
                                                      :options="services" style="margin-top: 5px">
                                            </v-select>

                                        </td>
                                        <td><textarea class="form-control ml-10 mt-1" v-model="item.description"
                                                      placeholder="description"></textarea>
                                        </td>
                                        <td><input type="number" class="form-control ml-10" v-model="item.cost"
                                                   placeholder="cost" style="margin-top: 5px;">
                                        </td>
                                        <td>
                                            <i class="fa fa-minus-circle ml-10 fs-20" @click="removeItem(k)"
                                               v-show="k || ( !k && form.status_of_covid_implementation.length > 1)"></i>
                                            <i class="fa fa-plus-circle ml-10 fs-20" @click="addItem(k)"
                                               v-show="k == form.status_of_covid_implementation.length-1"></i>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>O&M costs this month (KES)</h6>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Service</th>
                                        <th>Amount</th>
                                        <th></th>
                                    </tr>
                                    <tr v-for="(item,k) in form.operations_costs" :key="k">
                                        <td>
                                            <v-select label="name" placeholder="Select Service"
                                                      v-model="item.id" :reduce="s => s.id"
                                                      :options="operationCosts" style="margin-top: 5px">
                                            </v-select>

                                        </td>
                                        <td>
                                            <vue-numeric separator="," v-model="item.amount"
                                                         class="form-control"
                                                         required></vue-numeric>
                                        </td>
                                        <td>
                                            <i class="fa fa-minus-circle ml-10 fs-20" @click="removeOp(k)"
                                               v-show="k || ( !k && form.operations_costs.length > 1)"></i>
                                            <i class="fa fa-plus-circle ml-10 fs-20" @click="addOp(k)"
                                               v-show="k == form.operations_costs.length-1"></i>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Revenues collected this month (KES)</label>
                                        <vue-numeric separator="," v-model="form.revenue" class="form-control"
                                                     required></vue-numeric>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Total CLSG amount disbursed to date (KES)</label>
                                        <vue-numeric separator="," v-model="form.clsg_total" class="form-control"
                                                     required></vue-numeric>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Status of resolution of issues (if any) raised in previous
                                            performance
                                            verification reports</label>
                                        <div class="d-inline-block custom-control custom-radio mr-1">
                                            <input type="radio" class="custom-control-input"
                                                   name="status_of_resolution"
                                                   id="yes" value="1" v-model="form.status_of_resolution">
                                            <label class="custom-control-label" for="yes">Yes</label>
                                        </div>
                                        <div class="d-inline-block custom-control custom-radio mr-1">
                                            <input type="radio" class="custom-control-input"
                                                   name="status_of_resolution"
                                                   id="no" value="0" v-model="form.status_of_resolution">
                                            <label class="custom-control-label" for="no">No</label>
                                        </div>

                                        <div class="form-group" v-if="form.status_of_resolution ==1"
                                             style="margin-top: 4%">
                                            <label>Comment</label>
                                            <textarea class="form-control" required
                                                      v-model="form.status_of_resolution_comment"></textarea>
                                        </div>
                                    </div>


                                    <div class="col-md-6 form-group">
                                        <label>Challenges (if any) encountered during the reporting period and
                                            mitigation
                                            measures</label>
                                        <div class="d-inline-block custom-control custom-radio mr-1">
                                            <input type="radio" class="custom-control-input" name="challenges"
                                                   id="yes_1"
                                                   value="1" v-model="form.challenges">
                                            <label class="custom-control-label" for="yes_1">Yes</label>
                                        </div>
                                        <div class="d-inline-block custom-control custom-radio mr-1">
                                            <input type="radio" class="custom-control-input" name="challenges"
                                                   id="no_1"
                                                   value="0" v-model="form.challenges">
                                            <label class="custom-control-label" for="no_1">No</label>
                                        </div>

                                        <div class="form-group" v-if="form.challenges ==1" style="margin-top: 4%">
                                            <label>Challenges encountered Comment</label>
                                            <textarea class="form-control" required
                                                      v-model="form.challenges_comment"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="height: 92%">
                        <div class="card-header">
                            <p>Expected activities for the next month (specifying any planned procurement or
                                contracting)</p>
                        </div>
                        <div class="card-content">
                            <div class="card-body" style="padding-top: 0">
                                <div class="form-group">
                                    <table style="width: 100%">
                                        <tr>
                                            <th width="50%">Activity</th>
                                            <th><span class="ml-10">Description</span></th>
                                            <th></th>
                                        </tr>
                                        <tr v-for="(item,k) in form.expected_activities" :key="k">
                                            <td>
                                                <v-select label="name" placeholder="Select Activity"
                                                          v-model="item.activity" :reduce="s => s.id"
                                                          :options="services">
                                                </v-select>
                                            </td>
                                            <td><textarea class="form-control ml-10 mt-1"
                                                          v-model="item.description"
                                                          placeholder="description"></textarea>
                                            </td>

                                            <td>
                                                <i class="fa fa-minus-circle ml-10 fs-20" @click="removeActivity(k)"
                                                   v-show="k || ( !k && form.expected_activities.length > 1)"></i>
                                                <i class="fa fa-plus-circle ml-10 fs-20" @click="addActivity(k)"
                                                   v-show="k == form.expected_activities.length-1"></i>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group text-center" style="margin-top: 2%">
                <!--                    <button class="btn btn-warning" v-if="loading" type="button">Sending ... <i-->
                <!--                        class="feather icon-loader"></i></button>-->
                <button type="submit" class="btn btn-primary">
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
        services: {type: Array},
        operationCosts: {required: true, type: Array},
        wsp_report: {type: [Object, Array]}
    },
    data() {
        return {
            error: '',
            mths: [],
            form: {
                month: moment().month(),
                year: moment().year(),
                revenue: '',
                operations_costs: [{id: '', amount: '', document: ''}],
                clsg_total: '',
                challenges: 1,
                challenges_comment: '',
                status_of_resolution: 1,
                status_of_resolution_comment: '',
                status_of_covid_implementation: [{service: '', description: '', cost: '', document: ''}],
                expected_activities: [{activity: '', description: ''}]
            },
            loading: false
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
            if (this.wsp_report) {
                this.form.revenue = this.wsp_report.revenue;
                this.form.month = this.wsp_report.month;
                this.form.year = this.wsp_report.year;
                this.form.clsg_total = this.wsp_report.clsg_total;
                this.form.challenges = this.wsp_report.challenges;
                this.form.challenges_comment = this.wsp_report.challenges_comment;
                this.form.status_of_resolution = this.wsp_report.status_of_resolution;
                this.form.status_of_resolution_comment = this.wsp_report.status_of_resolution_comment;
                this.form.status_of_resolution_comment = this.wsp_report.status_of_resolution_comment;
                this.form.status_of_covid_implementation = [];
                this.wsp_report.status_of_covid_implementation.forEach(x => {
                    this.form.status_of_covid_implementation.push({
                        service: x.service, description: x.description, cost: x.cost, document: x.document
                    })
                });
                this.form.expected_activities = [];
                this.wsp_report.expected_activities.forEach(x => {
                    this.form.expected_activities.push({
                        activity: x.activity, description: x.description
                    })
                });
                this.form.operations_costs = [];
                this.wsp_report.operations_costs.forEach(x => {
                    this.form.operations_costs.push({
                        id: x.id, amount: x.amount, description: x.description
                    })
                });
            }
        },
        removeItem(i) {
            this.form.status_of_covid_implementation.splice(i, 1);
        },
        addItem() {
            this.form.status_of_covid_implementation.push({service: '', description: '', cost: '', document: ''});

        },
        removeOp(i) {
            this.form.operations_costs.splice(i, 1);
        },
        addOp() {
            this.form.operations_costs.push({id: '', amount: '', document: ''});

        },
        removeActivity(i) {
            this.form.expected_activities.splice(i, 1);
        },
        addActivity() {
            this.form.expected_activities.push({activity: '', description: ''});

        },
        postData() {
            let activities = this.validateActivities();
            if (activities === "empty") return this.$toastr.e("Activities fields cannot be empty.");
            if (!activities) return this.$toastr.e("All activities fields are required.");
            let impl = this.validateImplemetationStatus();
            if (impl === "empty") return this.$toastr.e("Status of implementation fields cannot be empty.");
            if (!impl) return this.$toastr.e("All Status of implementation fields are required.")

            this.error = '';
            this.loading = true;
            axios.post("/wsp-reporting", this.form).then(() => {
                this.$swal({
                    title: 'Success',
                    text: "WSP Monthly reported created successfully! Proceed to add attachments!!",
                    icon: 'success'
                }).then((result) => {
                    if (result.value) {
                        location.reload();
                    }
                });
            }).catch(error => {
                this.error = error.response;
            });

        },

        validateImplemetationStatus() {
            let empty_field = false;
            if (this.form.status_of_covid_implementation[0]["service"] == "") {
                return 'empty';
            }
            this.form.status_of_covid_implementation.forEach(s => {
                if (s.description == "" || s.item_name == "") {
                    empty_field = true;
                    return;
                }
            })
            if (empty_field) return false;
            return true;
        },
        validateActivities() {
            let empty_field = false;
            if (this.form.expected_activities[0]["activity"] == "") {
                return 'empty';
            }
            this.form.expected_activities.forEach(s => {
                if (s.activity == "" || s.description == "") {
                    empty_field = true;
                    return false;
                }
            })
            if (empty_field) return false;
            return true;
        },
        validateChallenges() {
            if (this.form.challenges == 1) {
                if (this.form.challenges_cooment == "") {
                    return false;
                }
            }
        },
        validateResolutions() {
            if (this.form.status_of_resolution == 1) {
                if (this.form.status_of_resolution_comment == "") {
                    return false;
                }
            }
        },
    }
}
</script>

<style>
.row > div {
    width: 100%;
}

.fs-20 {
    font-size: 20px;
}

.vs__search {
    height: 28px !important;
    margin-top: 1px !important;
    margin-bottom: 6px !important;
}
</style>
