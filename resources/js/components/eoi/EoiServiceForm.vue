<template>
    <ValidationObserver v-slot="{ handleSubmit }">
        <div class="col-md-12">
            <h5>Breakdown of short-term COVID-19 related emergency interventions and estimated costs:</h5>
            <form @submit.prevent="handleSubmit(onSubmit)" class="row">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Type of service / items</th>
                        <th>Name of Low income area and number of facilities required</th>
                        <th>Total No. required</th>
                    </tr>
                    </thead>
                    <tr v-for="(service,i) in service_areas" :key="i">
                        <td>{{ service.name }}</td>
                        <ValidationProvider tag="td" :name="'Name of Low income areas ' + i" rules="required"
                                            v-slot="{ errors }">
                            <input type="text" v-model="service.areas" class="form-control">
                            <span class="text-danger">{{ errors[0] }}</span>
                        </ValidationProvider>

                        <ValidationProvider tag="td" :name="'Total No ' + i" rules="required|numeric"
                                            v-slot="{ errors }">
                            <input type="text" v-model="service.total" class="form-control">
                            <span class="text-danger">{{ errors[0] }}</span>
                        </ValidationProvider>
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
        eoi_id: {required: true, type: String},
        submitUrl: {required: true, type: String},
        services: {required: true, type: Array},
    },
    data: () => ({
        error: '',
        program_manager: '',
        fixed_grant: null,
        variable_grant: null,
        emergency_intervention: null,
        operation_costs: null,
        water_service_areas: '',
        total_people_water_served: null,
        proportion_served: null
    }),
    computed: {
        total() {
            if (this.fixed_grant && this.variable_grant) {
                return this.fixed_grant + this.variable_grant;
            }
            return 0;
        },
        service_areas() {
            return this.services.map(obj => ({...obj, areas: '', total: null, eoi_id: this.eoi_id}));
        }
    },
    methods: {
        onSubmit() {
            axios.post(this.submitUrl, {
                services: this.service_areas
            }).then(response => {
                this.pricing = response.data;
                this.show_summary = true;
            });
        }
    }
}
</script>

