<template>
    <ValidationObserver v-slot="{ handleSubmit }">
        <div class="col-md-12">
            <form @submit.prevent="handleSubmit(onSubmit)" class="row">
                <div class="col-md-6">
                    <ValidationProvider name="Program Manager" rules="required" v-slot="{ errors }"
                                        class="row form-group">
                        <label class="control-label col-md-4">Program Manager</label>
                        <input v-model="eoi.program_manager" type="text" class="form-control col-md-8">
                        <span class="text-danger">{{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Fixed Grant" rules="required|numeric" v-slot="{ errors }"
                                        class="row form-group">
                        <label class="control-label col-md-4">Fixed Grant</label>
                        <input type="text" v-model="eoi.fixed_grant" class="form-control col-md-8">
                        <span>{{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Variable Grant" rules="required|numeric" v-slot="{ errors }"
                                        class="row form-group">
                        <label class="control-label col-md-4">Estimated Variable
                            Grant</label>
                        <input type="text" v-model="eoi.variable_grant" class="form-control col-md-8">
                        <span class="text-danger">{{ errors[0] }}</span>
                    </ValidationProvider>
                    <div class="row form-group">
                        <label class="control-label col-md-4">Total</label>
                        <input type="text" name="total" v-model="total" readonly class="form-control col-md-8">
                    </div>
                </div>
                <div class="col-md-6">
                    <p>Total Funding will be used as indicated:</p>
                    <ValidationProvider name="COVID-19 emergency interventions" rules="required" v-slot="{ errors }"
                                        class="row form-group">
                        <label class="control-label col-md-6">1. Short-term
                            COVID-19 emergency interventions</label>
                        <input type="text" v-model="eoi.emergency_intervention" class="form-control col-md-6">
                        <span class="text-danger">{{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider name="Operation & Maintenanance Costs" rules="required" v-slot="{ errors }"
                                        class="row form-group">
                        <label class="control-label col-md-6">2. Operation & Maintenance
                            Costs</label>
                        <input type="text" v-model="eoi.operation_costs" class="form-control col-md-6">
                        <span class="text-danger">{{ errors[0] }}</span>
                    </ValidationProvider>
                </div>
                <hr>
                <p class="col-md-12">The company serves low income areas as detailed in the table below</p>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Population Served</th>
                        <th>Name of Low Income Areas</th>
                        <th>Total No of People Served</th>
                    </tr>
                    </thead>
                    <tr>
                        <td>Water Services</td>
                        <td>
                            <ValidationProvider name="Name of low income areas" rules="required|min:5"
                                                v-slot="{ errors }">
                                <textarea v-model="eoi.water_service_areas" class="form-control"
                                          rows="3"></textarea>
                                <span class="text-danger">{{ errors[0] }}</span>
                            </ValidationProvider>

                        </td>
                        <td>
                            <ValidationProvider name="Total No of People Served" rules="required|numeric"
                                                v-slot="{ errors }">
                                <input type="text" v-model="eoi.total_people_water_served" class="form-control">
                                <span class="text-danger">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </td>
                    </tr>
                    <tr>
                        <td>Proportion of low income population served</td>
                        <td>
                            <ValidationProvider name="Proportion of low income population" rules="required|numeric"
                                                v-slot="{ errors }">
                                <input type="text" v-model="eoi.proportion_served" class="form-control">
                                <span class="text-danger">{{ errors[0] }}</span>
                            </ValidationProvider>
                        </td>
                    </tr>
                </table>
                <div class="form-group pull-right">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </ValidationObserver>
</template>

<script>
export default {
    props: {
        submitUrl: {required: true, type: String},
        current_eoi: {required: false, type: Object}
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
            proportion_served: null
        }
    }),
    computed: {
        total() {
            if (this.fixed_grant && this.variable_grant) {
                return parseFloat(this.fixed_grant) + parseFloat(this.variable_grant);
            }
            return 0;
        }
    },
    methods: {
        onSubmit() {
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
    },
    mounted() {
        this.current_eoi ? this.eoi = this.current_eoi : this.eoi;
    },
}
</script>

