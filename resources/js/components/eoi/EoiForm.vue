<template>
    <ValidationObserver v-slot="{ handleSubmit }">
        <ul class="nav nav-tabs nav-fill">
            <li class="nav-item">
                <span :class="{'nav-link':true, active: currentStep === 1}">Step 1</span>
            </li>
            <li class="nav-item">
                <span :class="{'nav-link':true, active: currentStep === 2}">Step 2</span>
            </li>
            <li class="nav-item">
                <span :class="{'nav-link':true, active: currentStep === 3}">Step 3</span>
            </li>
            <li class="nav-item">
                <span :class="{'nav-link':true, active: currentStep === 4}">Step 4</span>
            </li>
            <li class="nav-item">
                <span :class="{'nav-link':true, active: currentStep === 5}">Step 5</span>
            </li>
        </ul>
        <form @submit.prevent="handleSubmit(onSubmit)" class="col-md-12 mt-4">
            <div v-html="$error.handle(error)"/>
            <ValidationObserver v-if="currentStep === 1">
                <step-one :eoi="eoi"/>
            </ValidationObserver>
            <ValidationObserver v-else-if="currentStep === 2">
                <step-two :eoi="eoi" :services="services"/>
            </ValidationObserver>
            <ValidationObserver v-else-if="currentStep === 3">
                <step-three :eoi="eoi" :connections="connections"/>
            </ValidationObserver>
            <ValidationObserver v-else-if="currentStep === 4">
                <step-four :eoi="eoi" :estimated-costs="estimatedCosts"/>
            </ValidationObserver>
            <ValidationObserver v-else-if="currentStep === 5">
                <step-five :eoi="eoi" :operation-costs="operationCosts"/>
            </ValidationObserver>

            <div class="form-group pull-right">
                <button v-if="currentStep > 1" class="btn btn-primary" @click="previousStep"><i
                    class="fa fa-chevron-left"></i> Previous ggg {{currentStep}}
                </button>
                <button class="btn btn-success" v-if="currentStep ===5" type="submit">
                    Submit <i class="fa fa-send"></i>
                </button>
                <button v-else class="btn btn-primary" type="submit">
                    Next <i class="fa fa-chevron-right"></i>
                </button>
            </div>
        </form>
    </ValidationObserver>
</template>

<script>

import StepOne from "./StepOne";
import StepTwo from "./StepTwo";
import StepThree from "./StepThree";
import StepFour from "./StepFour";
import StepFive from "./StepFive";
import {SET_CURRENT_STEP} from "./../../store/eoi"
import {mapGetters} from "vuex";
export default {
    name: 'eoi-form',
    components: {
        StepOne,
        StepTwo,
        StepThree,
        StepFour,
        StepFive
    },
    props: {
        services: {required: true, type: Array},
        connections: {required: true, type: Array},
        estimatedCosts: {required: true, type: Array},
        operationCosts: {required: true, type: Array},
        existingEoi: {type: [Object, Array]},
        wsp: {type: Number},
    },
    data: () => ({
        error: '',
        eoi: {
            program_manager: '',
            fixed_grant: 0,
            variable_grant: 0,
            emergency_intervention_total: 0,
            operation_costs_total: 0,
            water_service_areas: '',
            total_people_water_served: 0,
            proportion_served: null,
            services: [{areas: "", total: 0, service_id: null}],
            connections: [{areas: '', total: 0, connection_id: null}],
            estimated_costs: [{unit: 0, total: 0, estimatedcost_id: null}],
            operation_costs: [{quantity: 0, unit_rate: 0, total: 0, operationcost_id: null}],
        },
        c_step:1,
        step:1
    }),
    created() {

      setTimeout(()=>{
          console.log(this.currentStep)
      },1000)
        if (this.existingEoi.id != undefined) {
            this.initEoi();
        }
    },
    watch:{
        currentStep(){
            console.log('step -> '+ this.currentStep)
            return this.currentStep;
        }
    },
    computed:{
      ...mapGetters({
          currentStep:"getStep"
      })
    },
    methods: {

        initEoi() {
            this.eoi.program_manager = this.existingEoi.program_manager;
            this.eoi.fixed_grant = this.existingEoi.fixed_grant;
            this.eoi.variable_grant = this.existingEoi.variable_grant;
            this.eoi.emergency_intervention_total = this.existingEoi.emergency_intervention_total;
            this.eoi.operation_costs_total = this.existingEoi.operation_costs_total;
            this.eoi.water_service_areas = this.existingEoi.water_service_areas;
            this.eoi.total_people_water_served = this.existingEoi.total_people_water_served;
            this.eoi.proportion_served = this.existingEoi.proportion_served;

            this.eoi.services = [];
            this.eoi.connections = [];
            this.eoi.estimated_costs = [];
            this.eoi.operation_costs = [];
            this.existingEoi.services.forEach(s => {
                this.eoi.services.push({areas: s.pivot.areas, total: s.pivot.total, service_id: s.pivot.service_id});
            })
            this.existingEoi.connections.forEach(s => {
                this.eoi.connections.push({
                    areas: s.pivot.areas,
                    total: s.pivot.total,
                    connection_id: s.pivot.connection_id
                });
            })
            this.existingEoi.estimatedCosts.forEach(s => {
                this.eoi.estimated_costs.push({
                    unit: s.pivot.unit,
                    total: s.pivot.total,
                    estimatedcost_id: s.pivot.estimatedcost_id
                });
            })
            this.existingEoi.operationCosts.forEach(s => {
                this.eoi.operation_costs.push({
                    quantity: s.pivot.quantity,
                    unit_rate: s.pivot.unit_rate,
                    total: s.pivot.total,
                    operationcost_id: s.pivot.operationcost_id
                });
            })
        },
        previousStep() {

            if (this.currentStep > 1) {
                this.$store.dispatch(SET_CURRENT_STEP,this.step--)
            }
        },
        onSubmit() {
            if (this.currentStep === 5) {
                if (this.existingEoi.id != undefined) {
                    this.updateData(this.existingEoi.id);
                } else
                    this.postData();
                return;
            }
            this.step++;
            this.$store.dispatch(SET_CURRENT_STEP,this.step)
        },
        postData() {
            this.eoi.wsp = this.wsp;
            axios.post('/eois', this.eoi).then(response => {
                this.$toastr.s("Expression of interest created!Proceed to attach Expression Of Interest Documents");
                location.href = "/eoi/" + response.data.id + "/services"
            }).catch(error => {
                this.error = error.response;
            });
        },
        updateData(id) {
            this.eoi.wsp = this.wsp;
            axios.patch(`/eois/${id}`, this.eoi).then(response => {
                this.$toastr.s("Expression of interest updated!Proceed to attach Expression Of Interest Documents");
                location.href = "/eoi/" + response.data.id + "/services"
            }).catch(error => {
                this.error = error.response;
            });
        }
    }
}
</script>

