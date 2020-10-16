<template>
    <div class="row">
        <div class="col-md-6">
            <ValidationProvider name="Program Manager" rules="required" v-slot="{ errors }"
                                class="row form-group">
                <label class="control-label col-md-4">Program Manager</label>
                <input v-model="eoi.program_manager" type="text" class="form-control col-md-8">
                <span class="ml-2 text-danger"> {{ errors[0] }}</span>
            </ValidationProvider>
            <ValidationProvider name="Fixed Grant" rules="required|numeric" v-slot="{ errors }"
                                class="row form-group">
                <label class="control-label col-md-4">Fixed Grant</label>
                <vue-numeric separator="," v-model="eoi.fixed_grant" class="form-control col-md-8"></vue-numeric>
                <span class="ml-2 text-danger"> {{ errors[0] }}</span>
            </ValidationProvider>
            <ValidationProvider name="Variable Grant" rules="required|numeric" v-slot="{ errors }"
                                class="row form-group">
                <label class="control-label col-md-4">Estimated Variable
                    Grant</label>
                <vue-numeric separator="," v-model="eoi.variable_grant" class="form-control col-md-8"></vue-numeric>
                <span class="ml-2 text-danger"> {{ errors[0] }}</span>
            </ValidationProvider>
            <div class="row form-group">
                <label class="control-label col-md-4">Total</label>
                <vue-numeric v-model="total" readonly="true" class="form-control col-md-8"/>
            </div>
        </div>
        <div class="col-md-6">
            <p>Total Funding will be used as indicated:</p>
            <ValidationProvider name="COVID-19 emergency interventions" rules="required" v-slot="{ errors }"
                                class="row form-group">
                <label class="control-label col-md-6">1. Short-term
                    COVID-19 emergency interventions</label>
                <vue-numeric separator="," v-model="eoi.emergency_intervention_total"
                             class="form-control col-md-6"></vue-numeric>
                <span class="ml-2 text-danger"> {{ errors[0] }}</span>
            </ValidationProvider>
            <ValidationProvider name="Operation & Maintenanance Costs" rules="required" v-slot="{ errors }"
                                class="row form-group">
                <label class="control-label col-md-6">2. Operation & Maintenance
                    Costs</label>
                <vue-numeric separator="," v-model="eoi.operation_costs_total"
                             class="form-control col-md-6"></vue-numeric>
                <span class="ml-2 text-danger"> {{ errors[0] }}</span>
            </ValidationProvider>
            <ValidationProvider name="Breakdown" :rules="'min_value:'+total+'|max_value:'+total"
                                v-slot="{ errors }"
                                class="row form-group">
                <input type="hidden" readonly="true" v-model="total_breakdown"/>
                <span class="ml-2 text-danger"> {{ errors[0] }}</span>
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
                        <vue-numeric separator="," v-model="eoi.total_people_water_served"
                                     class="form-control"></vue-numeric>
                        <span class="text-danger">{{ errors[0] }}</span>
                    </ValidationProvider>
                </td>
            </tr>
            <tr>
                <td>Proportion of low income population (%)</td>
                <td>
                    <ValidationProvider name="Proportion of low income population" rules="required|numeric"
                                        v-slot="{ errors }">
                        <input type="text" placeholder="% of people served" v-model="eoi.proportion_served"
                               class="form-control">
                        <span class="text-danger">{{ errors[0] }}</span>
                    </ValidationProvider>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        eoi: {required: false, type: Object}
    },
    computed: {
        total: {
            get: function () {
                if (this.eoi.fixed_grant && this.eoi.variable_grant) {
                    return parseFloat(this.eoi.fixed_grant) + parseFloat(this.eoi.variable_grant);
                }
                return 0;
            },
            set: function (n) {
                return n;
            }
        },
        total_breakdown: {
            get: function () {
                if (this.eoi.emergency_intervention_total && this.eoi.operation_costs_total) {
                    return parseFloat(this.eoi.emergency_intervention_total) + parseFloat(this.eoi.operation_costs_total);
                }
                return 0;
            },
            set: function (n) {
                return n;
            }
        }
    },
}
</script>
