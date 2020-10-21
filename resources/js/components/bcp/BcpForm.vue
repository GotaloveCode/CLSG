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
                        <span class="text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Introduction" rules="required"
                                        v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>Introduction</label>
                        <textarea v-model="bcp.introduction" type="text" class="form-control" data-toggle="tooltip"
                                  title="Tsection providing the context and rationale of the BCP. The objective of the BCP is to ensure the WSP maintains services during the pandemic period, including implementing special short-term COVID-19 emergency interventions targeting vulnerable communities (low-income and informal settlements)."></textarea>
                        <span class="text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Planning Assumptions" rules="required"
                                        v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>Planning Assumptions</label>
                        <textarea v-model="bcp.planning_assumptions" type="text" class="form-control"
                                  data-toggle="tooltip"
                                  title="Outline the planning assumptions – including identifying essential functions that must remain operational during the pandemic- e.g. source water pumping, complete water treatment, treated water pumping etc.  Essential functions, operations and support requirements will continue to be people-dependent- implying that social distancing, hygiene, health screening and other measures may need to be implemented to protect the staff of the WSP.  Also, mention whether disruptions in supply chains, transportation restrictions, and staffing reductions could affect the performance of essential functions."></textarea>
                        <span class="text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Training, alternative work schedules and delegation of authority"
                                        rules="required" v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>Training, alternative work schedules and delegation of authority</label>
                        <textarea v-model="bcp.training" type="text" class="form-control"
                                  data-toggle="tooltip"
                                  title="In this section, WSPs should outline training plans for all primary staff and back-up staff identified above for essential functions. Employees in non-essential and essential positions may be trained to perform essential tasks that are not part of their job description. Also, outline plans (if any) to institute alternative work schedules and home-based work to promote social distancing and continuity of operations. WSP should also indicate plans for delegation of authority to help assure continuity of operations over an extended time period"></textarea>
                        <span class="text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="COVID-19 Emergency Response Plan for Vulnerable Customers"
                                        rules="required" v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>COVID-19 Emergency Response Plan for Vulnerable Customers</label>
                        <textarea v-model="bcp.emergency_response_plan" type="text" class="form-control"
                                  data-toggle="tooltip"
                                  title="In this section, the WSP should outline plans to protect the health of its staff, including COVID-19 screening, plans for distribution of PPE equipment and supplies, promotion of basic hygiene, disinfection of workplaces, travel restrictions and social distancing etc)"></textarea>
                        <span class="text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Staff Health Protection" rules="required" v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>Staff Health Protection</label>
                        <textarea v-model="bcp.staff_health_protection" type="text" class="form-control"
                                  data-toggle="tooltip"
                                  title="In this section, the WSP should outline plans to protect the health of its staff, including COVID-19 screening, plans for distribution of PPE equipment and supplies, promotion of basic hygiene, disinfection of workplaces, travel restrictions and social distancing etc)"></textarea>
                        <span class="text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Supply Chains for Essential Products and Services" rules="required"
                                        v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>Supply Chains for Essential Products and Services</label>
                        <textarea v-model="bcp.supply_chain" type="text" class="form-control" data-toggle="tooltip"
                                  title="IIn this section, outline plans to supplement existing inventory to keep essential services functioning. Vendors of critical products and services shall be identified. Discussions with vendors shall include vendor plans for ongoing services and/or shipments in the event of absences, shortages, or disruptions in transportation systems. WSPs may initiate pre-solicited, signed and standing agreements with contractors and other third parties to ensure fulfillment of supply and service requirements"></textarea>
                        <span class="text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Communication Plan" rules="required"
                                        v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>Communication Plan</label>
                        <textarea v-model="bcp.communication_plan" type="text" class="form-control"
                                  data-toggle="tooltip"
                                  title="In this section, outline a communications plan and mechanisms to provide relevant information to internal and external stakeholders during the pandemic. If a plan already exists, simply refer to it"></textarea>
                        <span class="text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Government Subsidy" rules="required"
                                        v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>Government Subsidy</label>
                        <vue-numeric separator="," v-model="bcp.government_subsidy" class="form-control"
                                     data-toggle="tooltip"
                                     title="Any existing monthly government subsidy WSP is receiving"></vue-numeric>
                        <span class="text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>
                    <h5 class="col-md-12">BCP Team</h5>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Unit</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tr is="team-row"
                            v-for="(d, index) in bcp.bcp_teams"
                            @add="addMember"
                            @remove="removeMember(index)"
                            :team="d"
                            v-bind:key="index"
                            :index="index"/>
                    </table>
                    <h5 class="col-md-12">Essential Operations</h5>
                    <h6 class="col-md-12">Identification of Essential Operations and Staffing needs</h6>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Priority level</th>
                            <th>Essential Function</th>
                            <th>Primary Staff</th>
                            <th>Backup Staff</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tr is="essential-operation-row"
                            v-for="(d, index) in bcp.essential_operations"
                            @add="addEssential"
                            @remove="removeEssential(index)"
                            :essential_functions="essential_functions"
                            :primary_staff="primary_staff"
                            :backup_staff="backup_staff"
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
import EssentialOperationRow from "./EssentialOperationRow";
import RevenueRow from "./RevenueRow";
import TeamRow from "./TeamRow";

export default {
    name: "BcpForm",
    components: {
        EssentialOperationRow,
        RevenueRow,
        TeamRow
    },
    props: {
        submitUrl: {required: true, type: String},
        primary_staff: {required: true, type: Array},
        backup_staff: {required: true, type: Array},
        essential_functions: {required: true, type: Array},
        wsp_id: {type: String},
    },
    data: () => ({
        error: '',
        bcp: {
            wsp_id: null,
            government_subsidy: 0,
            executive_summary: '',
            introduction: '',
            planning_assumptions: '',
            training: '',
            staff_health_protection: '',
            emergency_response_plan: '',
            communication_plan: '',
            supply_chain: '',
            essential_operations: [{
                priority_level: '',
                essentialfunction_id: null,
                primary_staff: '',
                backup_staff: ''
            }],
            bcp_teams: [{name: '', role: 'designated BCP coordinator', unit: ''}, {
                name: '',
                role: 'alternate BCP coordinator',
                unit: ''
            }],
            projected_revenues: [{month: 10, year: 2020, amount: 0}]
        }
    }),
    mounted() {
        this.setWspId();
    },
    methods: {
        setWspId() {
            this.bcp.wsp_id = this.wsp_id;
        },
        onSubmit() {
            this.error = '';
            axios.post(this.submitUrl, this.bcp).then(response => {
                this.$toastr.s(response.data.message);
            }).catch(error => {
                this.error = error.response;
            });
        },
        addEssential() {
            this.bcp.essential_operations.push({
                priority_level: '',
                essentialfunction_id: null,
                primary_staff: '',
                backup_staff: ''
            });
        },
        removeEssential(index) {
            if (this.bcp.essential_operations.length > 1) {
                this.bcp.essential_operations.splice(index, 1);
            }
        },
        addMember() {
            this.bcp.bcp_teams.push({name: '', role: 'designated BCP coordinator', unit: ''});
        },
        removeMember(index) {
            if (this.bcp.bcp_teams.length > 1) {
                this.bcp.bcp_teams.splice(index, 1);
            }
        },
        addRevenue() {
            this.bcp.projected_revenues.push({month: 10, year: 2020, amount: 0});
        },
        removeRevenue(index) {
            if (this.bcp.projected_revenues.length > 1) {
                this.bcp.projected_revenues.splice(index, 1);
            }
        }
    }
}
</script>

