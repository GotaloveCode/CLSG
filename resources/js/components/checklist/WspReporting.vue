<template>
    <div>
        <div v-html="$error.handle(error)"/>
        <template v-if="show">
<!--            <view-checklist :checklist="checklist_item" :essentials="essentials" :customers="customers" :staff="staff" :communication="communication"></view-checklist>-->
        </template>
        <div v-if="!show">
            <form @submit.prevent="postData()">
                <div class="row">
                    <h4 class="text-uppercase col-md-12 text-center">A. GENERAL </h4>
                    <div class="col-md-12 form-group">
                        <br>
                        <fieldset class="the-fieldset">
                            <legend class="the-legend"><label class="fyr">Status of implementation of COVID-19 emergency interventions (both physical and financial progress)</label></legend>
                            <table style="width: 100%">
                                <tr>
                                    <th>Item Name</th>
                                    <th><span class="ml-10">Description</span></th>
                                    <th></th>
                                </tr>
                                <tr v-for="(item,k) in form.status_of_covid_implementation" :key="k">
                                    <td>
                                        <input type="text" class="form-control" v-model="item.item_name" placeholder="name" style="margin-top: 5px">
                                    </td>
                                    <td><input type="text" class="form-control ml-10" v-model="item.description" placeholder="description" style="margin-top: 5px;">
                                    </td>

                                    <td>
                                        <i class="fa fa-minus-circle ml-10 fs-20" @click="removeItem(k)"
                                           v-show="k || ( !k && form.status_of_covid_implementation.length > 1)"></i>
                                        <i class="fa fa-plus-circle ml-10 fs-20" @click="addItem(k)"
                                           v-show="k == form.status_of_covid_implementation.length-1"></i>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Revenues collected this month (KES)</label>
                        <vue-numeric separator="," v-model="form.revenue" class="form-control" required></vue-numeric>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>O&M costs this month (KES)</label>
                        <vue-numeric separator="," v-model="form.operations_costs" class="form-control" required></vue-numeric>
                    </div>

                    <div class="col-md-4 form-group">
                        <label>Total CLSG amount disbursed to date (KES)</label>
                        <vue-numeric separator="," v-model="form.clsg_total" class="form-control" required></vue-numeric>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="the-fieldset">
                            <legend class="the-legend"><label class="fyr">Status of resolution of issues (if any) raised in previous performance verification reports</label></legend>
                        <div class="d-inline-block custom-control custom-radio mr-1">
                            <input type="radio" class="custom-control-input" name="status_of_resolution" id="yes" value="1" v-model="form.status_of_resolution">
                            <label class="custom-control-label" for="yes">Yes</label>
                        </div>
                        <div class="d-inline-block custom-control custom-radio mr-1">
                            <input type="radio" class="custom-control-input" name="status_of_resolution" id="no"  value="0" v-model="form.status_of_resolution">
                            <label class="custom-control-label" for="no">No</label>
                        </div>

                            <div class="form-group" v-if="form.status_of_resolution ==1" style="margin-top: 4%">
                                <label>Comment</label>
                                <textarea class="form-control" required v-model="form.status_of_resolution_comment"></textarea>
                            </div>
                        </fieldset>
                    </div>


                    <div class="col-md-6 form-group">
                        <fieldset class="the-fieldset">
                        <legend class="the-legend"><label class="fyr">Challenges (if any) encountered during the reporting period and mitigation
                                measures</label></legend>
                        <div class="d-inline-block custom-control custom-radio mr-1">
                            <input type="radio" class="custom-control-input" name="challenges" id="yes_1" value="1" v-model="form.challenges">
                            <label class="custom-control-label" for="yes_1">Yes</label>
                        </div>
                        <div class="d-inline-block custom-control custom-radio mr-1">
                            <input type="radio" class="custom-control-input" name="challenges" id="no_1"  value="0" v-model="form.challenges">
                            <label class="custom-control-label" for="no_1">No</label>
                        </div>

                    <div class="form-group" v-if="form.challenges ==1" style="margin-top: 4%">
                        <label>Challenges encountered Comment</label>
                        <textarea class="form-control" required v-model="form.challenges_cooment"></textarea>
                    </div>
                        </fieldset>
                    </div>
                  <div class="form-group col-md-12">
                      <br>
                      <fieldset class="the-fieldset">
                          <legend class="the-legend"><label class="fyr">Expected activities for the next month (specifying any planned procurement or contracting)</label></legend>
                          <table style="width: 100%">
                              <tr>
                                  <th>Activity</th>
                                  <th><span class="ml-10">Description</span></th>
                                  <th></th>
                              </tr>
                              <tr v-for="(item,k) in form.expected_activities" :key="k">
                                  <td>
                                      <v-select label="name" placeholder="Select Activity"
                                                v-model="item.activity" :reduce="s => s.id" :options="services">
                                      </v-select>
                                  </td>
                                  <td><input type="text" class="form-control ml-10" v-model="item.description" placeholder="description" style="margin-top: 5px;">
                                  </td>

                                  <td>
                                      <i class="fa fa-minus-circle ml-10 fs-20" @click="removeActivity(k)"
                                         v-show="k || ( !k && form.expected_activities.length > 1)"></i>
                                      <i class="fa fa-plus-circle ml-10 fs-20" @click="addActivity(k)"
                                         v-show="k == form.expected_activities.length-1"></i>
                                  </td>
                              </tr>
                          </table>
                      </fieldset>
                  </div>
                </div>

                <div class="row">
                <h4 class="text-uppercase col-md-12 text-center">B. PERFORMANCE SCORECARD</h4>
                </div>
                <div class="row">

                   <div class="col-md-6">
                       <fieldset class="the-fieldset">
                           <legend class="the-legend"><label class="fyr">Business Continuity Plan (BCP) approved by the Board</label></legend>
                           <div class="form-group">
                               <label>Achievement(brief self-assessment)</label>
                               <input type="text" class="form-control" v-model="form.bcp_score" disabled>
                           </div>
                           <div class="form-group">
                               <label>List of evidence provided</label>
                               <textarea  class="form-control" v-model="form.bcp_evidence"></textarea>

                           </div>

                       </fieldset>
                   </div>

                    <div class="col-md-6">
                                <fieldset class="the-fieldset">
                               <legend class="the-legend"><label class="fyr">COVID-19 Emergency Response Plan (ERP) for vulnerable consumers approved by the Board</label></legend>
                            <div class="form-group">
                            <label>Achievement(brief self-assessment)</label>
                            <input type="text"  class="form-control" v-model="form.erp_score" disabled>
                            </div>
                             <div class="form-group" style="margin-left: 1.5%">
                            <label>List of evidence provided</label>
                          <textarea  class="form-control" v-model="form.erp_evidence"></textarea>
                            </div>
                         </fieldset>
                    </div>
                    <div class="col-md-6">
                             <fieldset class="the-fieldset">
                            <legend class="the-legend"><label class="fyr">Monthly reporting on BCP and ERP activities</label></legend>
                            <div class="form-group">
                            <label>Achievement(brief self-assessment)</label>
                             <input type="text" class="form-control" v-model="form.bcp_erp_score" disabled>
                            </div>
                             <div class="form-group" style="margin-left: 1.5%">
                            <label>List of evidence provided</label>
                          <textarea  class="form-control" v-model="form.bcp_erp_evidence"></textarea>

                             </div>
                          </fieldset>
                    </div>

                    <div class="col-md-6">
                        <br>
                              <fieldset class="the-fieldset">
                               <legend class="the-legend"><label class="fyr">Improved financial management of the CLSG. Personnel expenditures as a percentage of O&M expenditures shall not vary by more than 5% of the amounts spent in the previous period</label></legend>
                            <div class="form-group">
                            <label>Achievement(brief self-assessment)</label>
                             <input type="text"  class="form-control" v-model="form.financial_score" disabled>
                             </div>
                            <div class="form-group" style="margin-left: 1.5%">
                           <label>List of evidence provided</label>
                          <textarea  class="form-control" v-model="form.financial_evidence"></textarea>
                            </div>
                          </fieldset>
                    </div>
                    <div class="col-md-6">
                            <fieldset class="the-fieldset">
                             <legend class="the-legend"><label class="fyr">Quarterly reporting on the performance of the CLSG (pass/fail)</label></legend>
                            <div class="form-group">
                            <label>Achievement(brief self-assessment)</label>
                                <input type="text" class="form-control" v-model="form.performance_score" disabled>
                           </div>

                             <div class="form-group">
                            <label>List of evidence provided</label>
                          <textarea  class="form-control" v-model="form.performance_evidence"></textarea>
                            </div>
                            </fieldset>
                    </div>
                    <div class="col-md-6">
                        <br>
                            <fieldset class="the-fieldset">
                             <legend class="the-legend"><label class="fyr">Regulatory compliance (pass/fail)</label></legend>
                            <div class="form-group">
                            <label>Achievement(brief self-assessment)</label>
                             <input type="text"  class="form-control" v-model="form.compliance_score" disabled>
                           </div>
                             <div class="form-group">
                            <label>List of evidence provided</label>
                          <textarea  class="form-control" v-model="form.compliance_evidence"></textarea>
                            </div>
                            </fieldset>
                    </div>

                        <div class="col-md-6">
                            <fieldset class="the-fieldset">
                             <legend class="the-legend"><label class="fyr">Maintain at least 50 percent collection efficiency</label></legend>
                            <div class="d-inline-block custom-control custom-radio mr-1">
                                <input type="radio" class="custom-control-input" name="collection_efficiency" id="yes_e" value="1" v-model="form.collection_efficiency">
                                <label class="custom-control-label" for="yes_e">Yes</label>
                            </div>
                            <div class="d-inline-block custom-control custom-radio mr-1">
                                <input type="radio" class="custom-control-input" name="collection_efficiency" id="no_e"  value="0" v-model="form.collection_efficiency">
                                <label class="custom-control-label" for="no_e">No</label>
                            </div>

                                <div class="form-group" v-if="form.collection_efficiency ==1" style="margin-top: 4%">
                                    <label>Comment</label>
                                    <textarea class="form-control" v-model="form.collection_efficiency_comment"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Achievement(brief self-assessment)</label>
                                    <input type="text" class="form-control" v-model="form.collection_efficiency_score" disabled>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-md-6">
                            <br>
                            <fieldset class="the-fieldset">
                                <legend class="the-legend"><label class="fyr">Maintain NRW at pre-COVID levels</label></legend>
                            <div class="d-inline-block custom-control custom-radio mr-1">
                                <input type="radio" class="custom-control-input" name="nrw" id="yes_n" value="1" v-model="form.nrw">
                                <label class="custom-control-label" for="yes_n">Yes</label>
                            </div>
                            <div class="d-inline-block custom-control custom-radio mr-1">
                                <input type="radio" class="custom-control-input" name="nrw" id="no_n"  value="0" v-model="form.nrw">
                                <label class="custom-control-label" for="no_n">No</label>
                            </div>

                        <div class="form-group" v-if="form.nrw ==0" style="margin-top: 4%">
                            <label>Maintain NRW at pre-COVID levels Comment</label>
                            <textarea class="form-control" v-model="form.nrw_comment"></textarea>
                        </div>
                                <div class="form-group" style="margin-top: 2%">
                                    <label>Achievement(brief self-assessment)</label>
                                    <input type="text" class="form-control" v-model="form.nrw_score" disabled>
                                </div>
                            </fieldset>
                        </div>

                        <div class="col-md-6">
                            <br>
                            <fieldset class="the-fieldset">
                                <legend class="the-legend"><label class="fyr">Maintain at least 8 hours of service per day in urban areas</label></legend>
                            <div class="d-inline-block custom-control custom-radio mr-1">
                                <input type="radio" class="custom-control-input" name="service_per_day" id="yes_c" value="1" v-model="form.service_per_day">
                                <label class="custom-control-label" for="yes_c">Yes</label>
                            </div>
                            <div class="d-inline-block custom-control custom-radio mr-1">
                                <input type="radio" class="custom-control-input" name="service_per_day" id="no_c"  value="0" v-model="form.service_per_day">
                                <label class="custom-control-label" for="no_c">No</label>
                            </div>

                        <div class="form-group" v-if="form.service_per_day ==1" style="margin-top: 4%">
                            <label>Comment</label>
                            <textarea class="form-control" v-model="form.service_per_day_comment"></textarea>
                        </div>
                                <div class="form-group" style="margin-top: 2%">
                                    <label>Achievement(brief self-assessment)</label>
                                    <input type="text" class="form-control" v-model="form.nrw_score" disabled>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-6">
                            <fieldset class="the-fieldset"><legend class="the-legend"><label class="fyr">Maintain drinking water quality within acceptable range</label></legend>
                            <div class="d-inline-block custom-control custom-radio mr-1">
                                <input type="radio" class="custom-control-input" name="drinking_water" id="yes_d" value="1" v-model="form.drinking_water">
                                <label class="custom-control-label" for="yes_d">Yes</label>
                            </div>
                            <div class="d-inline-block custom-control custom-radio mr-1">
                                <input type="radio" class="custom-control-input" name="drinking_water" id="no_d"  value="0" v-model="form.drinking_water">
                                <label class="custom-control-label" for="no_d">No</label>
                            </div>

                        <div class="form-group" v-if="form.drinking_water ==1" style="margin-top: 4%">
                            <label>Comment</label>
                            <textarea class="form-control" v-model="form.drinking_water_comment"></textarea>
                        </div>
                                <div class="form-group" style="margin-top: 2%">
                                    <label>Achievement(brief self-assessment)</label>
                                    <input type="text" class="form-control" v-model="form.drinking_water_score" disabled>
                                </div>
                            </fieldset>
                        </div>
                </div>


                   <div class="form-group text-center" style="margin-top: 2%">
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
import ViewWspReporting from "./ViewWspReporting";

export default {
    props:{
        services:{type:Array}
    },
    data() {
        return {
            error: '',
            form: {
                revenue: 0,
                operations_costs: 0,
                clsg_total:0,
                challenges:1,
                challenges_cooment:'',
                status_of_resolution:1,
                status_of_resolution_comment:'',
                status_of_covid_implementation: [{item_name:'',description:''}],
                expected_activities: [{activity:'',description:''}],
                collection_efficiency:1,
                collection_efficiency_comment:'',
                nrw:1,
                nrw_comment:'',
                service_per_day:1,
                service_per_day_comment:'',
                drinking_water:1,
                drinking_water_comment:'',
                bcp_score:'10%',
                bcp_evidence:'',
                erp_score:'10%',
                erp_evidence:'',
                bcp_erp_score:'10%',
                bcp_erp_evidence:'',
                financial_score:'10%',
                financial_evidence:'',
                performance_score:'10%',
                performance_evidence:'',
                compliance_score:'10%',
                compliance_evidence:'',
                collection_efficiency_score:'10%',
                nrw_score:'10%',
                drinking_water_score:'10%'
            },
            loading: false,
            show: false
        }
    },
    created() {
    console.log(this.services)
    },
    watch:{
      'form.status_of_covid_implementation'(){
          console.log(this.form.status_of_covid_implementation)
      }
    },
    methods: {
        removeItem(i) {
            this.form.status_of_covid_implementation.splice(i, 1);
        },
        addItem() {
            this.form.status_of_covid_implementation.push({item_name: '',description:''});

        },
        removeActivity(i) {
            this.form.expected_activities.splice(i, 1);
        },
        addActivity() {
            this.form.expected_activities.push({activity: '',description:''});

        },
        postData() {
            let activities = this.validateActivities();
           if (activities==="empty") return this.$toastr.e("Activities fields are cannot be empty.");
           if (!activities) return this.$toastr.e("All activities fields are required.") ;
           let impl = this.validateImplemetationStatus();
           if (impl ==="empty") return this.$toastr.e("Status of implementation fields cannot be empty.");
           if (!impl) return this.$toastr.e("All Status of implementation fields are required.")

            this.error = '';
            this.loading = true;
            axios.post("/reports/wsp-reporting", this.form).then((res) => {
                console.log('success')
                console.log(res.data)
                //window.location.href = "/reports/wasp-reporting-list"
            }).catch(error => {
                this.error = error.response;
            });

        },

        validateImplemetationStatus(){
            let empty_field=false;
            if (this.form.status_of_covid_implementation[0]["description"] ==""){
                return 'empty';
            }
            this.form.status_of_covid_implementation.forEach(s => {
                if (s.description =="" || s.item_name ==""){
                    empty_field = true;
                    return false;
                }
            })
            if (empty_field) return false;
            return true;
        },
        validateActivities(){
            let empty_field=false;
            if (this.form.expected_activities[0]["activity"] ==""){
                return 'empty';
            }
            this.form.expected_activities.forEach(s => {
                if (s.activity =="" || s.description ==""){
                    empty_field = true;
                    return false;
                }
            })
            if (empty_field) return false;
            return true;
        },
        validateChallenges(){
            if (this.form.challenges ==1){
                if (this.form.challenges_cooment ==""){
                    return false;
                }
            }
        },
        validateResolutions(){
            if (this.form.status_of_resolution ==1){
                if (this.form.status_of_resolution_comment ==""){
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
.the-legend {
    border-style: none;
    border-width: 0;
    font-size: 14px;
    line-height: 20px;
    margin-bottom: 0;
    width: auto;
    padding: 0 10px;
    border: 1px solid #e0e0e0;
}
.the-fieldset {
    border: 1px solid #e0e0e0;
    padding: 10px;
}
.fyr{
    font-weight:800
}
.ml-10{
    margin-left: 10px;
}
.mt-5{
    margin-top: 5px;
}
.fs-20{
    font-size: 20px;
}
</style>
