<template>
    <form>
        <div>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-uppercase text-center">A. General </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label style="margin-left: 10px">Status of BCP implementation (summary of progress based on checklist</label>
                        <input type="text" class="form-control" v-model="format.bcp_status_implementation" required  style="margin-left: 10px;width: 94%" disabled>
                    </div>
                    <div class="form-group">
                        <label style="margin-left: 10px">Status of implementation of COVID-19 emergency interventions (both physical and financial progress)</label>
                        <input type="text" class="form-control" v-model="format.covid_status_implementation" required  style="margin-left: 10px;width: 94%" disabled>
                    </div>
                    <div class="form-group">
                        <label style="margin-left: 10px">Revenues collected this month (KES)</label>
                        <vue-numeric separator="," v-model="format.revenues_collected" class="form-control" required style="margin-left: 10px;width: 94%" disabled></vue-numeric>

                    </div>
                    <div class="form-group">
                        <label  style="margin-left: 10px">O&M costs this month (KES)</label>
                        <vue-numeric separator="," v-model="format.o_m_costs" class="form-control" required style="margin-left: 10px;width: 94%" disabled></vue-numeric>

                    </div>
                    <div class="form-group">
                        <label style="margin-left: 10px">Total CLSG amount disbursed to date (KES)</label>
                        <vue-numeric separator="," v-model="format.amount_disbursed" class="form-control" required style="margin-left: 10px;width: 94%" disabled></vue-numeric>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="form-group">
                        <label>Status of resolution of issues (if any) raised in previous performance verification reports</label>
                        <input type="text" class="form-control" v-model="format.resolution_status" required  style="width: 94%" disabled>
                    </div>
                    <div class="form-group">
                        <label>Challenges (if any) encountered during the reporting period and mitigation measures</label>
                        <textarea  class="form-control" required v-model="format.challenges" placeholder="Challenges" style="width: 94%" disabled></textarea>
                    </div>
                    <div class="form-group">
                        <label>Expected activities for the next month (specifying any planned procurement or contracting)</label>
                        <textarea  class="form-control" v-model="format.expected_activities_next_month" style="width: 94%" required disabled></textarea>
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
            <div class="col-md-6" v-for="score in format.score_details" style="margin-top: -10px">
                <div class="card">
                    <div class="card-header">
                        <p><i class="fa fa-angle-double-right" aria-hidden="true"></i><b>{{getName(score.id)}}:</b></p>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body" style="padding-top: 0">
                          <span style="display: flex">
                            <div class="form-group">
                            <label>Achievement(brief self-assessment)</label>
                          <textarea  class="form-control" v-model="score.achievement" disabled></textarea>
                            </div>
                             <div class="form-group" style="margin-left: 1.5%">
                            <label style="margin-left: 10%;">List of evidence provided</label>
                          <textarea  class="form-control" v-model="score.evidence" disabled></textarea>
                            </div>
                          </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group text-center">
            <button type="button" class="btn btn-warning" @click="goBack()"><i class="fa fa-arrow-left" aria-hidden="true"> Back</i>
            </button>
        </div>
    </form>
</template>


<script>

export default {
    props:{
        format:{type:Object},
        items:{type:Array}
    },
    created(){
        this.listen();
    },

    methods:{
        getName(id){
            return this.items.find(s => s.id === id).name;
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
        },
        goBack(){
            window.location.href = "/reports/report-format-list";
        }
    }
}
</script>
