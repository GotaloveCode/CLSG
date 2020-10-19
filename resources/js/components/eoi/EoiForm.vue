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
            <div v-html="$error.handle(error)" />
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
                    class="fa fa-chevron-left"></i> Previous
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
        submitUrl: {required: true, type: String},
        services: {required: true, type: Array},
        connections: {required: true, type: Array},
        estimatedCosts: {required: true, type: Array},
        operationCosts: {required: true, type: Array},
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
        currentStep: 1,
    }),
    methods: {
        previousStep() {
            if (this.currentStep > 1) {
                this.currentStep--;
            }
        },
        onSubmit() {
            if (this.currentStep === 5) {
                this.postData();
                return;
            }

            this.currentStep++;
        },
        postData() {
            axios.post(this.submitUrl, this.eoi).then(response => {
                this.$toastr.s("Expression of interest created!Proceed to attach Expression Of Interest Documents");
                location.href = "/eoi/" + response.data.id + "/services"
            }).catch(error => {
                this.error = error.response;
            });
        }
    }
}
</script>

