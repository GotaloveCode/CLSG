<template>
    <div>
        <h5>Breakdown of short-term COVID-19 related emergency interventions and estimated costs:</h5>
        <table class="table">
            <thead>
            <tr>
                <th>Estimated costs</th>
                <th>Unit Cost (KES)</th>
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

