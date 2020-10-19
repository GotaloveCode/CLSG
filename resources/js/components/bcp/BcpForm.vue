<template>
    <ValidationObserver v-slot="{ handleSubmit }">
        <div v-html="$error.handle(error)"/>
        <form class="form" @submit.prevent="handleSubmit(onSubmit)">
            <div class="form-body">
                <div class="row">
                    <ValidationProvider name="Executive Summary" rules="required" v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>Executive Summary</label>
                        <textarea v-model="bcp.executive_summary" type="text" class="form-control"
                                  data-toggle="tooltip"
                                  title="This section synthesizes the entire business continuity plan, briefly summarizing all sections with a focus on the company’s key objectives, strategy and action plan. It also highlights key risks that the company will face in the implementation of its plans and states mitigation strategies to manage such risk. Ideally, the Executive Summary section will be drafted such that it can stand on its own."></textarea>
                        <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Rationale for Business Continuity Plan" rules="required"
                                        v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>Rationale for Business Continuity Plan</label>
                        <textarea v-model="bcp.rationale" type="text" class="form-control" data-toggle="tooltip"
                                  title="The objective of the BCP is to ensure the WSP maintains objectives during the pandemic period, including implementing special short-term COVID-19 emergency interventions targeting vulnerable communities (low-income and informal settlements)."></textarea>
                        <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Company overview including market landscape" rules="required"
                                        v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>Company overview including market landscape</label>
                        <textarea v-model="bcp.company_overview" type="text" class="form-control" data-toggle="tooltip"
                                  title="The BCP shall contain a brief overview of the company including the market landscape. This section should give an indication of the situation pre, during and post COVID-19."></textarea>
                        <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Business Environment Analysis" rules="required" v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>Business Environment Analysis</label>
                        <textarea v-model="bcp.environment_analysis" type="text" class="form-control"
                                  data-toggle="tooltip"
                                  title="The Business environment analysis investigates Strengths, Weakness, Opportunities and Threats (SWOT) factors and how each of these impacts the performance of the organization. The organization shall outline in its BCP the impact of these SWOT factors as well as strategies that will be adopted to ensure that the organizational objectives will still be achieved.
Business Environment in addition to the SWOT Analysis, the company should provide an overview of relevant developments within the sector including links to:
• Overall government policies governing the sector
• Water sector policies and national water objective strategy
• Other developments in the local market and business environment that affect WSPs.
"></textarea>
                        <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Strategic Direction" rules="required" v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>Strategic Direction</label>
                        <textarea v-model="bcp.strategic_direction" type="text" class="form-control"
                                  data-toggle="tooltip"
                                  title="This section shall outline how the WSP will prioritize its activities to ensure continuity and improved quality of objectives during and  after the COVID-19 pandemic period. A comprehensive business continuity plan reflects a realistic view of market and operational expectations, the short to medium interventions to mitigate against any risks to objective interruption plus a a consideration of the resources required to achieve these objectives with a consideration of the risks involved."></textarea>
                        <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Financing of the Business Continuity Plans" rules="required"
                                        v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>Financing of the Business Continuity Plans</label>
                        <textarea v-model="bcp.financing" type="text" class="form-control" data-toggle="tooltip"
                                  title="Given the inadequacy of financial resources for water and sanitation, WSPs will have to access a range of different funding opportunities to ensure realization of the activities in the BCP. The main sources of funding BCPs "></textarea>
                        <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Implementation Matrix" rules="required" v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>Implementation Matrix</label>
                        <textarea v-model="bcp.implementation_matrix" type="text" class="form-control"
                                  placeholder="The BCP shall contain a log frame of the activities to be undertaken with clear indicators to measure their attainment as well as the required resources i.e. What, how to measure attainment, Who, When, Resources required."></textarea>
                        <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Government Subsidy" rules="required" v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>Existing Government Subsidy</label>
                        <vue-numeric v-model="bcp.government_subsidy" separator="," class="form-control"></vue-numeric>
                        <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <div class="col-md-12">
                        <label>Specific Objectives</label>
                    </div>
                    <div is="objective-row" v-for="(d, index) in bcp.objectives"
                         @add="addObjective"
                         @remove="removeObjective(index)"
                         :objective="d"
                         v-bind:key="index"
                         :index="index"></div>
                    <h5 class="col-md-12">Breakdown of O&M costs:</h5>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Type of Service/item</th>
                            <th>Qty</th>
                            <th>Unit Cost (KES)</th>
                            <th>Total Cost (KES)</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tr is="operation-cost-row"
                            v-for="(d, index) in bcp.operation_costs"
                            @add="addCost"
                            @remove="removeCost(index)"
                            :operations="operationCostFields"
                            :operation="d"
                            v-bind:key="index"
                            :index="index"/>
                    </table>
                    <h5 class="col-md-12">Revenue Projections:</h5>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Amount (KES)</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tr is="revenue-row"
                            v-for="(d, index) in bcp.projected_revenues"
                            @add="addRevenue"
                            @remove="removeRevenue(index)"
                            :revenue="d"
                            v-bind:key="index"
                            :index="index"/>
                    </table>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check-square-o"></i> Save
                    </button>
                </div>
            </div>
        </form>
    </ValidationObserver>
</template>

<script>
import ObjectiveRow from "./ObjectiveRow";
import OperationCostRow from "../eoi/OperationCostRow";
import RevenueRow from "./RevenueRow";

export default {
    name: "BcpForm",
    components: {
        ObjectiveRow,
        OperationCostRow,
        RevenueRow
    },
    props: {
        submitUrl: {required: true, type: String},
        operationCosts: {required: true, type: Array},
        operationCostFields: {required: true, type: Array},
    },
    data: () => ({
        error: '',
        bcp: {
            government_subsidy: 0,
            executive_summary: '',
            rationale: '',
            company_overview: '',
            environment_analysis: '',
            strategic_direction: '',
            financing: '',
            implementation_matrix: '',
            objectives: [{description: ''}],
            operation_costs: [{quantity: 0, unit_rate: 0, total: 0, operationcost_id: null}],
            projected_revenues: [{month: 10, year: 2020, amount: 0}]
        }
    }),
    created() {
        if (this.operationCosts.length) {
            this.initCosts();
        }
    },
    methods: {
        onSubmit() {
            this.error = '';
            axios.post(this.submitUrl, this.bcp).then(response => {
                this.$toastr.s(response.data.message);
            }).catch(error => {
                this.error = error.response;
            });
        },
        addObjective() {
            this.bcp.objectives.push({description: ''});
        },
        removeObjective(index) {
            if (this.bcp.objectives.length > 1) {
                this.bcp.objectives.splice(index, 1);
            }
        },
        addCost() {
            this.bcp.operation_costs.push({quantity: null, unit_rate: null, total: null, operationcost_id: null});
        },
        removeCost(index) {
            if (this.bcp.operation_costs.length > 1) {
                this.bcp.operation_costs.splice(index, 1);
            }
        },
        addRevenue() {
            this.bcp.projected_revenues.push({month: 10, year: 2020, amount: 0});
        },
        removeRevenue(index) {
            if (this.bcp.projected_revenues.length > 1) {
                this.bcp.projected_revenues.splice(index, 1);
            }
        },
        initCosts() {
            let costs = []
            this.operationCosts.forEach(x => {
                costs.push({
                    quantity: x.pivot.quantity,
                    unit_rate: x.pivot.unit_rate,
                    total: x.pivot.total,
                    operationcost_id: x.id
                });
            });
            this.bcp.operation_costs = costs;
        }
    }
}
</script>
