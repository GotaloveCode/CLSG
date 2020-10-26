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
                                <label style="margin-left: 10px">Name of WSP</label>
                                <input type="text" class="form-control" v-model="form.wsp" required style="margin-left: 10px;width: 94%">
                            </div>
                            <div class="form-group">
                                <label style="margin-left: 10px">Reporting period (month)                                </label>
                                <input type="text" class="form-control" v-model="form.reporting_period" required  style="margin-left: 10px;width: 94%">
                            </div>
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
                                <input type="number" step="0.001" class="form-control" v-model="form.revenues_collected" required  style="margin-left: 10px;width: 94%">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>O&M costs this month (KES)</label>
                                <input type="number" step="0.001" class="form-control" v-model="form.o_m_costs" required  style="width: 94%">
                            </div>
                            <div class="form-group">
                                <label>Total CLSG amount disbursed to date (KES)</label>
                                <input type="number" step="0.001" class="form-control" v-model="form.amount_disbursed" required  style="width: 94%">
                            </div>
                            <div class="form-group">
                                <label>Status of resolution of issues (if any) raised in previous performance verification reports</label>
                                <input type="text" class="form-control" v-model="form.resolution_status" required  style="width: 94%">
                            </div>
                            <div class="form-group">
                                <label>Challenges (if any) encountered during the reporting period and mitigation measures</label>
                                <textarea  cols="20" rows="2" class="form-control" v-model="form.challenges" placeholder="Challenges" style="width: 94%"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Challenges (if any) encountered during the reporting period and mitigation measures</label>
                                <textarea  cols="20" rows="2" class="form-control" v-model="form.expected_activities_next_month" style="width: 94%"></textarea>
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
                          <textarea cols="30" rows="2" class="form-control" v-model="form.achievement[score.id]"  placeholder="Your comment here"></textarea>
                            </div>
                             <div class="form-group">
                            <label>List of evidence provided</label>
                          <textarea cols="30" rows="2" class="form-control" v-model="form.evidence[score.id]"  placeholder="Your comment here"></textarea>
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
                wsp:'',
                reporting_period:'',
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
            year:"getReportYear"
        })
    },
    methods:{
        postData(){
            let scores = this.validateScores();

            return ;
            // if (deter ==="negative_value") return this.$toastr.e("Negative values are not allowed!");
            // if (!deter) return this.$toastr.e("All Determination of CSLG Amount fields are required!");
            //
            // let scores = this.validateScores();
            // if (scores ==='negative_value') return this.$toastr.e("Negative values are not allowed!");
            // if (scores ==="greater_value") return this.$toastr.e("Score cannot be greater than total score!");
            // if (!scores) return this.$toastr.e("All Performance Score fields are required!");

            let data = {performance_score_details:this.scores_data,clsg_details:this.determination_data,wsp:this.form.wsp,recommendations:this.form.recommendations,verification_period:this.form.verification_period,verification_team:this.form.verification_team,month:this.month,year:this.year};

            axios.post("/reports/report-format",data)
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
            console.log(this.scores_data)
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
