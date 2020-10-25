<template>
    <div>
        <h5>Breakdown of short-term COVID-19 related emergency interventions and estimated costs:</h5>
        <table class="table">
            <thead>
            <tr>
                <th>Estimated costs</th>
                <th>Unit Cost (KES)</th>
                <th>Quantity</th>
                <th>Total cost (KES)</th>
            </tr>
            </thead>
            <tr is="estimated-cost-row"
                v-for="(d, index) in eoi.estimated_costs"
                @add="addCost"
                @remove="removeCost(index)"
                :costs="estimatedCosts"
                :cost="d"
                v-bind:key="index"
                :index="index"></tr>
            <tr>
                <th colspan="3">Total costs</th>
                <ValidationProvider tag="td" name="Total"
                                    :rules="'required|numeric|min_value:'+eoi.emergency_intervention_total+'|max_value:'+eoi.emergency_intervention_total"
                                    v-slot="{ errors }">
                    <vue-numeric separator="," v-model="total" disabled="true" class="form-control"></vue-numeric>
                    <span class="text-danger">{{ errors[0] }}</span>
                </ValidationProvider>
            </tr>
            <tr v-if="total>eoi.emergency_intervention_total">
                <td class="text-danger" colspan="3">The total Estimated Cost should not exceed Short-term COVID-19
                    emergency interventions total
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
import EstimatedCostRow from "./EstimatedCostRow";


export default {
    components: {
        EstimatedCostRow
    },
    props: {
        eoi: {required: true, type: Object},
        estimatedCosts: {required: true, type: Array},
    },
    methods: {
        addCost() {
            this.eoi.estimated_costs.push({unit: 0, cost: 0, quantity: 0, total: 0, estimatedcost_id: null});
        },
        removeCost(index) {
            if (this.eoi.estimated_costs.length > 1) {
                this.eoi.estimated_costs.splice(index, 1);
            }
        }
    },
    computed: {
        total: {
            get: function () {
                return this.eoi.estimated_costs.reduce((a, b) => ({total: a.total + b.total})).total;
            },
            set: function (n) {
                return n;
            }
        }
    }
}
</script>

