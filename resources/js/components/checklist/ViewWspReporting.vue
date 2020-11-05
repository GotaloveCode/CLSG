<template>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td>Name of WSP</td>
                            <td>{{ wsp_report.wsp }}</td>
                        </tr>
                        <tr>
                            <td>Reporting period</td>
                            <td>{{ wsp_report.month }} {{ wsp_report.year }}</td>
                        </tr>
                        <tr>
                            <td>Revenues collected this month (KES)</td>
                            <td>{{ $number.format(wsp_report.revenue) }}</td>
                        </tr>
                        <tr>
                            <td>Total CLSG amount disbursed to date (KES)</td>
                            <td>{{ $number.format(wsp_report.clsg_total) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">O&M costs this month (KES)</h4>
                    <table class="table table-borderless">
                        <tr>
                            <td>Service/Item</td>
                            <td>Cost</td>
                            <!--                                <td>Document</td>-->
                        </tr>
                        <tr v-for="(item,i) in wsp_report.operations_costs" :key="i">
                            <td>{{ getOperationname(item.id) }}</td>
                            <td>{{ $number.format(item.amount) }}</td>
                            <!--                                <td>{{ item.document }}</td>-->
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Status of implementation of COVID-19 emergency interventions (both physical
                        and financial
                        progress)</h6>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Service</th>
                            <th>Description</th>
                            <th>Cost</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="erp in wsp_report.status_of_covid_implementation">
                            <td>{{ getActivityName(erp.service) }}</td>
                            <td>{{ erp.description }}</td>
                            <td>{{ $number.format(erp.cost) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Expected activities for the next month (specifying any planned
                        procurement or contracting)
                    </h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Service</th>
                                <th>Description</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="activity in wsp_report.expected_activities">
                                <td>{{ getActivityName(activity.activity) }}</td>
                                <td>{{ activity.description }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="row card-body">
                    <div class="form-group col-md-6">
                        <h6 class="card-title">Challenges (if any) encountered during the reporting period and
                            mitigation measures</h6>
                        <p>{{ wsp_report.challenges == 1 ? 'Yes.' : 'No.' }}</p>
                        <h6 class="card-title" v-if="wsp_report.challenges_cooment">Comments</h6>
                        <p>{{ wsp_report.challenges_cooment }}</p>
                    </div>
                    <div class="form-group col-md-6">
                        <h6 class="card-title">Status of resolution of issues (if any) raised in previous
                            performance
                            verification reports</h6>
                        <p class="card-text">{{ wsp_report.status_of_resolution == 1 ? 'Yes.' : 'No.' }}</p>
                        <h6 class="card-title" v-if="wsp_report.status_of_resolution_comment">Comments</h6>
                        <p class="card-text">{{ wsp_report.status_of_resolution_comment }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        services: {type: Array},
        operationCosts: {required: true, type: Array},
        wsp_report: {type: [Object, Array]}
    },
    methods: {
        goBack() {
            window.location.href = "/reports/wsp-reporting-list";
        },
        getActivityName(id) {
            return this.services.find(s => s.id == id).name;
        },
        getOperationname(id) {
            return this.operationCosts.find(s => s.id == id).name;
        }
    }
}
</script>

