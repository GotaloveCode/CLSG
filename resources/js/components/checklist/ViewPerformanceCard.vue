<template>
    <div class="table-responsive">
        <div class="col-md-12 h5"><b>Period: </b> {{ score.month }} {{ score.year }}</div>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Performance Scorecard</th>
                <th>Achievement</th>
                <th>Comments</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td width="50%">Business Continuity Plan (BCP) approved by the Board</td>
                <td>{{ score.bcp_score }}%</td>
                <td></td>
            </tr>
            <tr>
                <td width="50%">COVID-19 Emergency Response Plan (ERP) for vulnerable consumers approved by
                    the Board
                </td>
                <td>{{ score.erp_score }}%</td>
                <td></td>
            </tr>
            <tr>
                <td>Monthly reporting on BCP and ERP activities</td>
                <td>{{ score.bcp_erp_score }}%</td>
                <td></td>
            </tr>
            <tr>
                <td width="50%">Improved financial management of the CLSG. Personnel expenditures as a
                    percentage of O&M expenditures shall not vary by more than 5% of the amounts spent in
                    the previous period
                </td>
                <td>{{ score.financial_score }}%</td>
                <td></td>
            </tr>
            <tr>
                <td width="50%">Quarterly reporting on the performance of the CLSG (pass/fail)</td>
                <td>{{ score.performance_score }}%</td>
                <td></td>
            </tr>
            <tr>
                <td width="50%">Regulatory compliance (pass/fail)</td>
                <td>{{ score.compliance_score }}%</td>
                <td></td>
            </tr>
            <tr>
                <td width="50%">Maintain at least 50 percent collection efficiency</td>
                <td>{{ score.collection_efficiency_score }}%</td>
                <td>{{ score.collection_efficiency_comment }}</td>
            </tr>
            <tr>
                <td width="50%">Maintain NRW at pre-COVID levels</td>
                <td>{{ score.nrw_score }}%</td>
                <td>{{ score.nrw_comment }}</td>
            </tr>
            <tr>
                <td>Maintain at least 8 hours of service per day in urban areas</td>
                <td>{{ score.service_per_day_score }}%</td>
                <td>{{ score.service_per_day_comment }}</td>
            </tr>
            <tr>
                <td width="50%">Maintain drinking water quality within acceptable range</td>
                <td>{{ score.drinking_water_score }}%</td>
                <td>{{ score.drinking_water_comment }}</td>
            </tr>
            <tr>
                <td width="50%"><b>Total</b></td>
                <td>{{ score.total }}%</td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>


<script>
export default {
    props: {
        score: {type: Object}
    }
}
</script>
