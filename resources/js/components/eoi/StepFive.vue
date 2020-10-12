<template>
    <div>
        <h5>Breakdown of O&M estimated costs:</h5>
        <table class="table">
            <thead>
            <tr>
                <th>Type of Service/item</th>
                <th>Qty</th>
                <th>Unit Cost (KES)</th>
                <th>Total Cost (KES)</th>
                <th></th>
            </tr>
            </thead>
            <tr is="operation-cost-row"
                v-for="(d, index) in eoi.operation_costs"
                @add="addCost"
                @remove="removeCost(index)"
                :operations="operationCosts"
                :operation="d"
                v-bind:key="index"
                :index="index"></tr>
        </table>
    </div>
</template>

<script>
import OperationCostRow from "./OperationCostRow";


export default {
    components: {
        OperationCostRow
    },
    props: {
        eoi: {required: true, type: Object},
        operationCosts: {required: true, type: Array},
    },
    methods: {
        addCost() {
            this.eoi.operation_costs.push({quantity: null, unit_rate: null, total: "", operationcost_id: null});
        },
        removeCost(index) {
            if (this.eoi.operation_costs.length > 1) {
                this.eoi.operation_costs.splice(index, 1);
            }
        }
    }
}
</script>

