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
                <span :class="{'nav-link':true, active: currentStep === 3}">Summary</span>
            </li>
            <li class="nav-item">
                <span :class="{'nav-link':true, active: currentStep === 4}">Complete</span>
            </li>
        </ul>
        <form @submit.prevent="handleSubmit(onSubmit)" class="col-md-12 mt-4">
                <ValidationObserver v-if="currentStep === 1">
                    <step-one :eoi="eoi"/>
                </ValidationObserver>
                <ValidationObserver v-else-if="currentStep === 2">
                    <step-two :services="services"/>
                </ValidationObserver>
                <ValidationObserver v-else-if="currentStep === 3">
                    <step-three :service="service" :services="services"/>
                </ValidationObserver>
                <div class="form-group pull-right">
                    <button v-if="currentStep > 1" class="btn btn-primary" type="submit"><i
                        class="fa fa-chevron-left"></i> Previous
                    </button>
                    <button class="btn btn-primary" type="submit">
                        <span v-if="currentStep ===4">Submit</span>
                        <span v-else>Next <i class="fa fa-chevron-right"></i></span>
                    </button>
                </div>
            </form>
    </ValidationObserver>
</template>

<script>
import StepOne from "./StepOne";
import StepTwo from "./EoiServiceForm";
import StepThree from "./OperationCostForm";

export default {
    components: {
        StepOne,
        StepTwo,
        StepThree
    },
    props: {
        submitUrl: {required: true, type: String},
    },
    data: () => ({
        error: '',
        eoi: {
            program_manager: '',
            fixed_grant: null,
            variable_grant: null,
            emergency_intervention: null,
            operation_costs: null,
            water_service_areas: '',
            total_people_water_served: null,
            proportion_served: null,
            services:[],
        },
        currentStep: 1,
    }),
    computed: {
        total() {
            if (this.eoi.fixed_grant && this.eoi.variable_grant) {
                return parseFloat(this.eoi.fixed_grant) + parseFloat(this.eoi.variable_grant);
            }
            return 0;
        }
    },
    methods: {
        onSubmit() {
            if (this.currentStep === 3) {
                this.postData();
                return;
            }

            this.currentStep++;
        },
        postData() {
            axios.post(this.submitUrl, {
                program_manager: this.program_manager,
                fixed_grant: this.fixed_grant,
                variable_grant: this.variable_grant,
                emergency_intervention: this.emergency_intervention,
                operation_costs: this.operation_costs,
                water_service_areas: this.water_service_areas,
                total_people_water_served: this.total_people_water_served,
                proportion_served: this.proportion_served
            }).then(response => {
                this.$toastr.s("Expression of interest created!Proceed to record Estimated Operation Costs and Covid interention measures");
                location.href = "/eoi/" + response.data.id + "/services"
            }).catch(error => {
                console.log("err", error);
            });
        }
    }
}
</script>

