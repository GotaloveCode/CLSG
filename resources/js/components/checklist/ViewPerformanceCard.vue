<template>
    <div>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="bg-yellow bg-lighten-4">
                                <tr>
                                    <th>Performance Scorecard</th>
                                    <th>Achievement</th>
                                    <th>Comments</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td width="50%">Business Continuity Plan (BCP) approved by the Board </td>
                                    <td>{{ score.bcp_score }}%</td>
                                    <td>blablabla</td>
                                </tr>
                                <tr>
                                    <td width="50%">COVID-19 Emergency Response Plan (ERP) for vulnerable consumers approved by the Board  </td>
                                    <td>{{ score.erp_score }}%</td>
                                    <td>qqqdwew</td>
                                </tr>
                                <tr>
                                    <td>Monthly reporting on BCP and ERP activities</td>
                                    <td>{{ score.bcp_erp_score }}%</td>
                                    <td>eeee</td>
                                </tr>
                                <tr>
                                    <td width="50%">Improved financial management of the CLSG. Personnel expenditures as a percentage of O&M expenditures shall not vary by more than 5% of the amounts spent in the previous period</td>
                                    <td>{{ score.financial_score }}%</td>
                                    <td>www</td>
                                </tr>
                                <tr>
                                    <td width="50%">Quarterly reporting on the performance of the CLSG (pass/fail)</td>
                                    <td>{{ score.performance_score }}%</td>
                                    <td>cc</td>
                                </tr>
                                <tr>
                                    <td width="50%">Regulatory compliance (pass/fail)</td>
                                    <td>{{ score.compliance_score }}%</td>
                                    <td>qq</td>
                                </tr>
                                <tr>
                                    <td width="50%">Maintain at least 50 percent collection efficiency</td>
                                    <td>{{ score.collection_efficiency_score }}%</td>
                                    <td>sss</td>
                                </tr>
                                <tr>
                                    <td width="50%">Maintain NRW at pre-COVID levels</td>
                                    <td>{{ score.nrw_score }}%</td>
                                    <td>dd</td>
                                </tr>
                                <tr>
                                    <td>Maintain at least 8 hours of service per day in urban areas </td>
                                    <td>{{ score.service_per_day_score }}%</td>
                                    <td>blablabla</td>
                                </tr>
                                <tr>
                                    <td width="50%">Maintain drinking water quality within acceptable range</td>
                                    <td>{{ score.drinking_water_score }}%</td>
                                    <td>blablabla</td>
                                </tr>
                                <tr>
                                    <td width="50%"><b>Total</b></td>
                                    <td>{{ score.total }}%</td>
                                    <td></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


        <div class="form-group text-center" style="margin-top: 1%">
            <button type="button" class="btn btn-warning" @click="goBack()"><i class="fa fa-arrow-left" aria-hidden="true"> Back</i>
            </button>
        </div>

    </div>
</template>


<script>
export default {
    props:{
        score: {type: Object}
    },
    created(){
        console.log(this.score)
    },
    methods:{
        goBack(){
            window.location.href = "/reports/performance-score-card-list";
        }

    }
}
</script>

<style>
#card-headings > .row > div {
    width: 100%;
}
</style>
