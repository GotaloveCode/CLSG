<template>
    <div>
        <template v-if="show_date_form && !show">
            <date-form></date-form>
        </template>
        <template v-if="show && !show_date_form">
            <view-format></view-format>
        </template>
        <div v-if="!show && !show_date_form">
            <form @submit.prevent="postData()">
                <div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-uppercase text-center">A. General </h4>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                <label style="margin-left: 10px">Status of BCP implementation (summary of progress based on checklist                                 </label>
                                <input type="text" class="form-control" v-model="form.bcp_status_implementation" required  style="margin-left: 10px;width: 94%">
                            </div>
                            <div class="form-group">
                                <label style="margin-left: 10px">Status of implementation of COVID-19 emergency interventions (both physical and financial progress)                               </label>
                                <input type="text" class="form-control" v-model="form.covid_status_implementation" required  style="margin-left: 10px;width: 94%">
                            </div>
                            <div class="form-group">
                                <label style="margin-left: 10px">Revenues collected this month (KES)</label>
                                <vue-numeric separator="," v-model="form.revenues_collected" class="form-control" required style="margin-left: 10px;width: 94%"></vue-numeric>

                            </div>
                            <div class="form-group">
                                <label  style="margin-left: 10px">O&M costs this month (KES)</label>
                                <vue-numeric separator="," v-model="form.o_m_costs" class="form-control" required style="margin-left: 10px;width: 94%"></vue-numeric>

                            </div>
                                <div class="form-group">
                                    <label style="margin-left: 10px">Total CLSG amount disbursed to date (KES)</label>
                                    <vue-numeric separator="," v-model="form.amount_disbursed" class="form-control" required style="margin-left: 10px;width: 94%"></vue-numeric>
                                </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label>Status of resolution of issues (if any) raised in previous performance verification reports</label>
                                <input type="text" class="form-control" v-model="form.resolution_status" required  style="width: 94%">
                            </div>
                            <div class="form-group">
                                <label>Challenges (if any) encountered during the reporting period and mitigation measures</label>
                                <textarea  class="form-control" required v-model="form.challenges" placeholder="Challenges" style="width: 94%"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Expected activities for the next month (specifying any planned procurement or contracting)</label>
                                <textarea  class="form-control" v-model="form.expected_activities_next_month" style="width: 94%" required></textarea>
                            </div>
                        </div>

                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-uppercase text-center">B.Performance Scorecard</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6" v-for="score in scores" style="margin-top: -10px">
                        <div class="card">
                            <div class="card-header">
                                <p><i class="fa fa-angle-double-right" aria-hidden="true"></i><b>{{score.name}}:</b></p>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body" style="padding-top: 0">
                          <span style="display: flex">
                            <div class="form-group">
                            <label>Achievement(brief self-assessment)</label>
                          <textarea  class="form-control" v-model="form.achievement[score.id]"></textarea>
                            </div>
                             <div class="form-group" style="margin-left: 1.5%">
                            <label style="margin-left: 10%;">List of evidence provided</label>
                          <textarea  class="form-control" v-model="form.evidence[score.id]"></textarea>
                            </div>
                          </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane" aria-hidden="true"> Submit</i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>


<script>
import ViewFormat from "./ViewFormat";
import DateForm from "./DateForm";
import {mapGetters} from "vuex";
export default {
    data(){
        return {
            form:{
                bcp_status_implementation:'',
                covid_status_implementation:'',
                revenues_collected:'',
                o_m_costs:'',
                amount_disbursed:'',
                resolution_status:'',
                challenges:'',
                expected_activities_next_month:'',
                achievement:[],
                evidence:[]
            },
            scores_data:[],
            show:false,
            show_date_form:true
        }
    },
    created(){
        this.listen();
    },
    computed:{
        ...mapGetters({
            scores:"getFormats",
            month:"getReportMonth",
            year:"getReportYear",
            wsp:"getWspId",
        })
    },
    methods:{
        postData(){
            if (!this.validateScores()) return this.$toastr.e("All Performance Scorecard fields are required.")
          this.form.wsp_id = this.wsp;
          this.form.month = this.month;
          this.form.year = this.year;
          this.form.scores = this.scores_data;
            axios.post("/reports/report-format",this.form)
                .then(res => {
                    this.show_date_form = true;
                    this.show = false;
                })

        },
        validateScores(){
            this.scores_data = [];
            let result = "";
            this.form.achievement.forEach((e,v) => {
              this.scores_data.push({id:v,achievement:e,evidence:""})
            })
            console.log(this.scores_data)
            console.log(this.scores_data.length)
            if (this.scores_data.length < 10) return false;

            this.form.evidence.forEach((e,v) => {
                for (let i=0;i<this.scores_data.length;i++){
                    if (this.scores_data[i]['id'] === v){
                        this.scores_data[i]['evidence'] = e;
                    }
                }
            })

            this.scores_data.forEach(value => {
                if (value.achievement === "" || value.evidence ===""){
                    result = false;
                    return;
                }
            })
            if (result ===false) return  false;
            return true;
        },

        listen(){
            eventBus.$on("format_form",() => {
                this.show_date_form = false;
                this.show = false;
            })
            eventBus.$on("view_format",() => {
                this.show_date_form = false;
                this.show = true;
            })
        }
    },
    components:{
        ViewFormat,
        DateForm
    }
}
</script>
