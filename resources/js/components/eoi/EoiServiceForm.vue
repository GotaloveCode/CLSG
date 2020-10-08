<template>
    <div>
        <h5>Breakdown of short-term COVID-19 related emergency interventions and estimated costs:</h5>
        <table class="table">
            <thead>
            <tr>
                <th>Type of service / items</th>
                <th>Name of Low income area and number of facilities required</th>
                <th>Total No. required</th>
            </tr>
            </thead>
            <tr is="service-row"
                v-for="(d, index) in eoi.services"
                @add="addService"
                @remove="removeService(index)"
                :services="services"
                :service="d"
                v-bind:key="index"
                :index="index"></tr>
            <tr>
                <th colspan="3">People served by</th>
            </tr>
            <tr v-for="(connection,i) in connection_areas" :key="i">
                <td v-text="connection.name"></td>
                <ValidationProvider tag="td" :name="'Name of Low income areas ' + i" rules="required"
                                    v-slot="{ errors }">
                    <input type="text" v-model="connection.areas" class="form-control">
                    <span class="text-danger">{{ errors[0] }}</span>
                </ValidationProvider>
                <ValidationProvider tag="td" :name="'Total No ' + i" rules="required|numeric"
                                    v-slot="{ errors }">
                    <input type="text" v-model="connection.total" class="form-control">
                    <span class="text-danger">{{ errors[0] }}</span>
                </ValidationProvider>
            </tr>
            <tr>
                <th>Estimated costs</th>
                <th>Unit Cost (KES)</th>
                <th>Total cost (KES)</th>
            </tr>
            <tr is="estimated-cost-row"
                v-for="(d, index) in eoi.estimated_costs"
                @add="addCost"
                @remove="removeCost(index)"
                :costs="estimatedCosts"
                :cost="d"
                v-bind:key="index"
                :index="index"></tr>
        </table>
    </div>
</template>

<script>
import ServiceRow from "./ServiceRow";
import EstimatedCostRow from "./EstimatedCostRow";


export default {
    components: {
        ServiceRow,
        EstimatedCostRow
    },
    props: {
        submitUrl: {required: true, type: String},
        services: {required: true, type: Array},
        connections: {required: true, type: Array},
        estimatedCosts: {required: true, type: Array},
    },
    data: () => ({
        error: '',
        eoi: {
            services: [{areas: "", total: "", service_id: null}],
            estimated_costs: [{unit: "", total: "", estimatedcost_id: null}]
        }
    }),
    computed: {
        total() {
            if (this.fixed_grant && this.variable_grant) {
                return this.fixed_grant + this.variable_grant;
            }
            return 0;
        },
        connection_areas() {
            return this.connections.map(obj => ({...obj, areas: '', total: null}))
        }
    },
    methods: {
        addService() {
            this.eoi.services.push({areas: "", total: "", service_id: null});
        },
        removeService(index) {
            if (this.eoi.services.length > 1) {
                this.eoi.services.splice(index, 1);
            }
        },
        addCost() {
            this.eoi.estimated_costs.push({unit: "", total: "", estimatedcost_id: null});
        },
        removeCost(index) {
            if (this.eoi.estimated_costs.length > 1) {
                this.eoi.estimated_costs.splice(index, 1);
            }
        }
    }
}
</script>

