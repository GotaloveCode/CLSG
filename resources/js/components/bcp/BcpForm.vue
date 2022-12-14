<template>
    <ValidationObserver v-slot="{ handleSubmit }">
        <div v-html="$error.handle(error)"/>
        <div class="alert alert-info alert-dismissible mb-2" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            Make sure you have created staff members before attempting to fill this form
        </div>
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
                        <br>
                        <div class="d-inline-block custom-control custom-radio mr-1">
                            <input type="radio" class="custom-control-input" name="government_subsidy" id="yes"
                                   value="1" v-model="bcp.government_subsidy" checked>
                            <label class="custom-control-label" for="yes">Yes</label>
                        </div>
                        <div class="d-inline-block custom-control custom-radio mr-1">
                            <input type="radio" class="custom-control-input" name="government_subsidy" id="no" value="0"
                                   v-model="bcp.government_subsidy">
                            <label class="custom-control-label" for="no">No</label>
                        </div>
                        <span class="text-danger"> {{ errors[0] }}</span>
                    </ValidationProvider>

                    <ValidationProvider name="Government Subsidy Amount" v-if="bcp.government_subsidy==1"
                                        v-slot="{ errors }"
                                        class="col-md-6 form-group">
                        <label>Government Subsidy Amount</label>
                        <vue-numeric separator="," v-model="bcp.government_subsidy_amount" class="form-control"
                                     data-toggle="tooltip"
                                     title="Government Subsidy Amount"></vue-numeric>
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
                            :staff="staff"
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
                            :staff="staff"
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
                            :months="mths"
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
import months from "../months";
export default {
    name: "BcpForm",
    components: {
        EssentialOperationRow,
        RevenueRow,
        TeamRow
    },
    props: {
        submitUrl: {required: true, type: String},
        staff: {required: true, type: Array},
        essential_functions: {required: true, type: Array},
        wsp_id: {type: String},
        existingBcp: {required: false, type: Object}
    },
    data: () => ({
        error: '',
        mths: [],
        bcp: {
            wsp_id: null,
            government_subsidy: 1,
            government_subsidy_amount: 0,
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
        },

    }),
    watch: {
        'bcp.government_subsidy'() {
            this.updateForm('government_subsidy', this.bcp.government_subsidy);
        },
        'bcp.supply_chain'() {
            this.updateForm('supply_chain', this.bcp.supply_chain);
        },
        'bcp.communication_plan'() {
            this.updateForm('communication_plan', this.bcp.communication_plan);
        },
        'bcp.emergency_response_plan'() {
            this.updateForm('emergency_response_plan', this.bcp.emergency_response_plan);
        },
        'bcp.staff_health_protection'() {
            this.updateForm('staff_health_protection', this.bcp.staff_health_protection);
        },
        'bcp.training'() {
            this.updateForm('training', this.bcp.training);
        },
        'bcp.planning_assumptions'() {
            this.updateForm('planning_assumptions', this.bcp.planning_assumptions);
        },
        'bcp.introduction'() {
            this.updateForm('introduction', this.bcp.introduction);
        },
        'bcp.government_subsidy_amount'() {
            this.updateForm('government_subsidy_amount', this.bcp.government_subsidy_amount);
        },
        'bcp.executive_summary'() {
            this.updateForm('executive_summary', this.bcp.executive_summary);
        }
    },
    mounted() {
        this.mths = months;
        this.setUp();
        this.setWspId();
        if (this.existingBcp) {
            this.initBcp();
        }
    },
    methods: {
        setUp() {
            if (this.openStorage()) {
                let bcp = this.openStorage();
                if (bcp.government_subsidy != undefined) this.bcp.government_subsidy = bcp.government_subsidy;
                if (bcp.government_subsidy_amount != undefined) this.bcp.government_subsidy_amount = bcp.government_subsidy_amount;
                if (bcp.executive_summary != undefined) this.bcp.executive_summary = bcp.executive_summary;
                if (bcp.introduction != undefined) this.bcp.introduction = bcp.introduction;
                if (bcp.planning_assumptions != undefined) this.bcp.planning_assumptions = bcp.planning_assumptions;
                if (bcp.staff_health_protection != undefined) this.bcp.staff_health_protection = bcp.staff_health_protection;
                if (bcp.training != undefined) this.bcp.training = bcp.training;
                if (bcp.emergency_response_plan != undefined) this.bcp.emergency_response_plan = bcp.emergency_response_plan;
                if (bcp.communication_plan != undefined) this.bcp.communication_plan = bcp.communication_plan;
                if (bcp.supply_chain != undefined) this.bcp.supply_chain = bcp.supply_chain;
            }
        },
        setWspId() {
            this.bcp.wsp_id = this.wsp_id;
        },
        initBcp() {
            this.bcp.government_subsidy = this.existingBcp.government_subsidy;
            this.bcp.government_subsidy_amount = this.existingBcp.government_subsidy_amount;
            this.bcp.executive_summary = this.existingBcp.executive_summary;
            this.bcp.introduction = this.existingBcp.introduction;
            this.bcp.planning_assumptions = this.existingBcp.planning_assumptions;
            this.bcp.training = this.existingBcp.training;
            this.bcp.staff_health_protection = this.existingBcp.staff_health_protection;
            this.bcp.emergency_response_plan = this.existingBcp.emergency_response_plan;
            this.bcp.communication_plan = this.existingBcp.communication_plan;
            this.bcp.supply_chain = this.existingBcp.supply_chain;

            this.bcp.bcp_teams = [];
            this.existingBcp.bcp_teams.forEach(s => {
                this.bcp.bcp_teams.push({name: s.name, role: s.role, unit: s.unit});
            });
            this.bcp.essential_operations = [];
            this.existingBcp.essential_operations.forEach(s => {
                this.bcp.essential_operations.push({
                    priority_level: s.priority_level,
                    essentialfunction_id: s.essentialfunction_id,
                    primary_staff: s.primary_staff,
                    backup_staff: s.backup_staff
                });
            });
            this.bcp.projected_revenues = [];
            this.existingBcp.projected_revenues.forEach(s => {
                this.bcp.projected_revenues.push({month: s.month, year: s.year, amount: s.amount});
            });
        },
        onSubmit() {
            this.error = '';
            this.existingBcp ? this.updateData() : this.postData();
        },
        postData() {
            axios.post(this.submitUrl, this.bcp).then(response => {
                this.$toastr.s(response.data.message);
                localStorage.removeItem('bcp');
                window.location.href = `/bcps/${response.data.bcp.id}/attachments`
            }).catch(error => {
                this.error = error.response;
            });
        },
        updateForm(input, value) {
            this.bcp[input] = value

            let storedForm = this.openStorage() // extract stored form
            if (!storedForm) storedForm = {} // if none exists, default to empty object

            storedForm[input] = value // store new value
            this.saveStorage(storedForm) // save changes into localStorage
        },
        openStorage() {
            return JSON.parse(localStorage.getItem('bcp'))
        },
        saveStorage(form) {
            localStorage.setItem('bcp', JSON.stringify(form))
        },
        updateData() {
            axios.put(this.submitUrl, this.bcp).then(() => {
                this.$toastr.s("BCP updated successfully!");
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

