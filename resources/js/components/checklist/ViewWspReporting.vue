<template>
    <div>
        <div class="row">
            <div class="col-md-6">
            <div class="card" style="height: 98%">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <h4 class="card-title">Name of WSP</h4>
                    <p class="card-text">{{wsp_report.wsp}}</p>
                </div>
            </div>
            </div>
            <div class="col-md-6">
            <div class="card" style="height: 98%">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <h4 class="card-title">Reporting period (month)</h4>
                    <p class="card-text">{{wsp_report.month}}</p>
                </div>
            </div>
            </div>
        </div>
         <div class="row">
             <div class="col-md-6">
                 <div class="card" style="height: 98%">
                     <div class="card-header">
                     </div>
                     <div class="card-body">
                         <h4 class="card-title">Revenues collected this month (KES)</h4>
                         <p class="card-text">{{wsp_report.revenue}}</p>
                     </div>
                 </div>
             </div>
             <div class="col-md-6">
                 <div class="card" style="height: 98%">
                     <div class="card-header">
                     </div>
                     <div class="card-body">
                         <h4 class="card-title">O&M costs this month (KES)</h4>
                         <p class="card-text">{{wsp_report.operations_costs}}</p>
                     </div>
                 </div>
             </div>
         </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card" style="height: 98%">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Total CLSG amount disbursed to date (KES)</h4>
                        <p class="card-text">{{wsp_report.clsg_total}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card" style="height: 98%">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Status of resolution of issues (if any) raised in previous performance verification reports</h4>
                        <p class="card-text">{{wsp_report.status_of_resolution ==1 ? 'Yes.' : 'No.'}}</p>
                        <h4 class="card-title" v-if="wsp_report.status_of_resolution_comment">Comments</h4>
                        <p class="card-text">{{wsp_report.status_of_resolution_comment}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="height: 98%">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Challenges (if any) encountered during the reporting period and mitigation measures</h4>
                        <p class="card-text">{{wsp_report.challenges ==1 ? 'Yes.' : 'No.'}}</p>
                        <h4 class="card-title" v-if="wsp_report.challenges_cooment">Comments</h4>
                        <p class="card-text">{{wsp_report.challenges_cooment}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="height: 98%">
                    <div class="card-header">
                        <h4>Expected activities for the next month (specifying any planned procurement or contracting)</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
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
                                        <td>{{getActivityName(activity.activity)}}</td>
                                        <td>{{activity.description}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="height: 98%">
                    <div class="card-header">
                        <h4>Status of implementation of COVID-19 emergency interventions (both physical and financial progress)</h4>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="erp in wsp_report.status_of_covid_implementation">
                                    <td>{{getActivityName(erp.service)}}</td>
                                    <td>{{erp.description}}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    props:{
        services:{type:Array},
        wsp_report:{type:[Object,Array]}
    },
     methods: {
        goBack(){
            window.location.href = "/reports/wsp-reporting-list";
        },
        getActivityName(id){
            return this.services.find(s => s.id ==id).name;
        }
    }
}
</script>

