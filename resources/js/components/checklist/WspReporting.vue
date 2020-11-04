<template>
    <div>
        <div v-html="$error.handle(error)"/>
        <template v-if="show">
            <view-wsp-reporting :services="services" :wsp_report="wsp_report"></view-wsp-reporting>
        </template>
        <div v-if="!show">
            <form @submit.prevent="postData()">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <div class="card" style="height: 92%">
                            <div class="card-header">
                                <p>Status of implementation of COVID-19 emergency interventions (both physical and
                                    financial progress)</p>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body" style="padding-top: 0">
                                    <table style="width: 100%">
                                        <tr>
                                            <th width="20%">Service</th>
                                            <th><span class="ml-10">Description</span></th>
                                            <th>Cost</th>
                                            <th>Evidence</th>
                                            <th></th>
                                        </tr>
                                        <tr v-for="(item,k) in form.status_of_covid_implementation" :key="k">
                                            <td>
                                                <v-select label="name" placeholder="Select Service"
                                                          v-model="item.service" :reduce="s => s.id"
                                                          :options="services" style="margin-top: 5px">
                                                </v-select>

                                            </td>
                                            <td><input type="text" class="form-control ml-10" v-model="item.description"
                                                       placeholder="description" style="margin-top: 5px;">
                                            </td>
                                            <td><input type="number" class="form-control ml-10" v-model="item.cost"
                                                       placeholder="cost" style="margin-top: 5px;">
                                            </td>
                                            <td>
                                                <span class="webkit"><input type="file" v-on:change="onImageChange($event,item.service,'covid_status')" class="form-control" accept=".pdf,.doc,.docx"></span>

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
                        <div class="card" style="height: 92%">
                            <div class="card-header">
                                <h4>O&M costs this month (KES)</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="form-group">
                                        <table style="width: 100%">
                                            <tr>
                                                <th width="20%">Service</th>
                                                <th>Amount</th>
                                                <th>Evidence</th>
                                                <th></th>
                                            </tr>
                                            <tr v-for="(item,k) in form.operations_costs" :key="k">
                                                <td>
                                                    <v-select label="name" placeholder="Select Service"
                                                              v-model="item.id" :reduce="s => s.id"
                                                              :options="services" style="margin-top: 5px">
                                                    </v-select>

                                                </td>
                                                <td>
                                                    <vue-numeric separator="," v-model="item.amount" class="form-control"
                                                                 required></vue-numeric>
                                                </td>
                                                <td>
                                                    <span class="webkit"><input type="file" v-on:change="onImageChange($event,item.id,'operations')" class="form-control" accept=".pdf,.doc,.docx"></span>
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
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <div class="card" style="height: 92%">
                        <div class="card-header">
                            <h4>Revenues collected this month (KES)</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <table style="width: 100%">
                                    <tr>
                                        <th>Amount</th>
                                        <th>Evidence</th>
                                        <th></th>
                                    </tr>
                                    <tr v-for="(item,k) in form.revenue" :key="k">
                                        <td>
                                            <vue-numeric separator="," v-model="item.amount" class="form-control"
                                                         required></vue-numeric>

                                        <input type="hidden"  v-model="item.index=k">
                                        </td>
                                        <td>
                                         <span class="webkit"><input type="file" v-on:change="onImageChange($event,item.index,'revenues')" class="form-control" accept=".pdf,.doc,.docx"></span>
                                        </td>
                                        <td>
                                            <i class="fa fa-minus-circle ml-10 fs-20" @click="removeRev(k)"
                                               v-show="k || ( !k && form.revenue.length > 1)"></i>
                                            <i class="fa fa-plus-circle ml-10 fs-20" @click="addRev(k)"
                                               v-show="k == form.revenue.length-1"></i>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card" style="height: 92%">
                            <div class="card-header">
                                <h4>Total CLSG amount disbursed to date (KES)</h4>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="form-group">
                                        <table style="width: 100%">
                                            <tr>
                                                <th>Amount</th>
                                                <th>Evidence</th>
                                                <th></th>
                                            </tr>
                                            <tr v-for="(item,k) in form.clsg_total" :key="k">
                                                <td>
                                                    <vue-numeric separator="," v-model="item.amount" class="form-control"
                                                                 required></vue-numeric>

                                                    <input type="hidden"  v-model="item.index=k">
                                                </td>
                                                <td>
                                                    <span class="webkit"><input type="file" v-on:change="onImageChange($event,item.index,'cslg')" class="form-control" accept=".pdf,.doc,.docx"></span>
                                                </td>
                                                <td>
                                                    <i class="fa fa-minus-circle ml-10 fs-20" @click="removeRev(k)"
                                                       v-show="k || ( !k && form.clsg_total.length > 1)"></i>
                                                    <i class="fa fa-plus-circle ml-10 fs-20" @click="addRev(k)"
                                                       v-show="k == form.clsg_total.length-1"></i>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                    <div class="card" style="height: 92%">
                        <div class="card-content collapse show">
                            <div class="card-body">
                               <div class="row">
                                <div class="col-md-6">
                                    <label>Status of resolution of issues (if any) raised in previous performance
                                        verification reports</label>
                                    <div class="d-inline-block custom-control custom-radio mr-1">
                                        <input type="radio" class="custom-control-input" name="status_of_resolution"
                                               id="yes" value="1" v-model="form.status_of_resolution">
                                        <label class="custom-control-label" for="yes">Yes</label>
                                    </div>
                                    <div class="d-inline-block custom-control custom-radio mr-1">
                                        <input type="radio" class="custom-control-input" name="status_of_resolution"
                                               id="no" value="0" v-model="form.status_of_resolution">
                                        <label class="custom-control-label" for="no">No</label>
                                    </div>

                                    <div class="form-group" v-if="form.status_of_resolution ==1" style="margin-top: 4%">
                                        <label>Comment</label>
                                        <textarea class="form-control" required
                                                  v-model="form.status_of_resolution_comment"></textarea>
                                    </div>
                                </div>


                                <div class="col-md-6 form-group">
                                    <label>Challenges (if any) encountered during the reporting period and mitigation
                                        measures</label>
                                    <div class="d-inline-block custom-control custom-radio mr-1">
                                        <input type="radio" class="custom-control-input" name="challenges" id="yes_1"
                                               value="1" v-model="form.challenges">
                                        <label class="custom-control-label" for="yes_1">Yes</label>
                                    </div>
                                    <div class="d-inline-block custom-control custom-radio mr-1">
                                        <input type="radio" class="custom-control-input" name="challenges" id="no_1"
                                               value="0" v-model="form.challenges">
                                        <label class="custom-control-label" for="no_1">No</label>
                                    </div>

                                    <div class="form-group" v-if="form.challenges ==1" style="margin-top: 4%">
                                        <label>Challenges encountered Comment</label>
                                        <textarea class="form-control" required
                                                  v-model="form.challenges_cooment"></textarea>
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
                        <div class="card-content collapse show">
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
                                            <td><input type="text" class="form-control ml-10" v-model="item.description"
                                                       placeholder="description" style="margin-top: 5px;">
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
                    <button type="submit"  class="btn btn-primary">
                        Submit <i class="feather icon-send"></i>
                    </button>

                </div>
            </form>
        </div>
    </div>
</template>

<script>
import ViewWspReporting from "./ViewWspReporting";

export default {
    props: {
        services: {type: Array},
        wsp_report: {type: [Object, Array]}
    },
    data() {
        return {
            error: '',
            form: {
                revenue:[{index:'',amount:'',document:''}],
                operations_costs: [{id:'',amount:'',document:''}],
                clsg_total: [{index:'',amount:'',document:''}],
                challenges: 1,
                challenges_cooment: '',
                status_of_resolution: 1,
                status_of_resolution_comment: '',
                status_of_covid_implementation: [{service: '',description: '',cost:'',document:''}],
                expected_activities: [{activity: '', description: ''}]
            },
            loading: false,
            show: false
        }
    },
    created() {
        console.log(this.services)
        this.setUp();
    },
    methods: {

        onImageChange(e,item_id,doc_type) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.createImage(files[0],item_id,doc_type);
        },
        createImage(file,item_id,doc_type) {
            console.log("walla")
            console.log(file);
            console.log(item_id);
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                if (doc_type =="covid_status") vm.form.status_of_covid_implementation.find(item => item.service ==item_id).document = e.target.result;
                if (doc_type =="revenues") vm.form.revenue.find(item => item.index ==item_id).document = e.target.result;
                if (doc_type =="cslg") vm.form.clsg_total.find(item => item.index ==item_id).document = e.target.result;
                if (doc_type =="operations") vm.form.operations_costs.find(item => item.id ==item_id).document = e.target.result;

            };
           reader.readAsDataURL(file);
        },
        setUp() {
            if (this.wsp_report.id != undefined) {
                this.show = true;
            }
        },
        removeItem(i) {
            this.form.status_of_covid_implementation.splice(i, 1);
        },
        addItem() {
            this.form.status_of_covid_implementation.push({service: '', description: '',cost: '',document:''});

        },
        removeRev(i) {
            this.form.revenue.splice(i, 1);
        },
        addRev() {
            this.form.revenue.push({index: '', amount: '',document:''});

        },
        removeCslg(i) {
            this.form.clsg_total.splice(i, 1);
        },
        addCslg() {
            this.form.clsg_total.push({index: '', amount: '',document:''});

        },
        removeOp(i) {
            this.form.operations_costs.splice(i, 1);
        },
        addOp() {
            this.form.operations_costs.push({id: '', amount: '',document:''});

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
            axios.post("/reports/wsp-reporting", this.form).then(() => {
                window.location.href = "/reports/wsp-reporting-list"
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
    },
    components: {
        ViewWspReporting
    }
}
</script>

<style>
.row > div {
    width: 100%;
}
.fs-20{
    font-size: 20px;
}
.vs__search{
    height: 28px !important;
    margin-top: 1px !important;
    margin-bottom: 6px !important;
}
</style>
