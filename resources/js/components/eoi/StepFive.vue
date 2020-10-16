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
                :index="index"/>
            <tr>
                <th>Total costs</th>
                <td></td>
                <td></td>
                <ValidationProvider tag="th" name="Total" :rules="'required|numeric|max_value:'+eoi.operation_costs_total"
                                    v-slot="{ errors }">
                    <vue-numeric separator="," v-model="total" readonly="true" class="form-control"></vue-numeric>
                    <span class="text-danger">{{ errors[0] }}</span>
                </ValidationProvider>
            </tr>
            <tr v-if="total>eoi.operation_costs_total">
                <td class="text-danger" colspan="5">The total Operation Cost should not exceed Operation & Maintenance Costs total
                </td>
            </tr>
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
    },
    computed: {
        total: {
            get: function () {
                return this.eoi.operation_costs.reduce((a, b) => ({total: a.total + b.total})).total;
            },
            set: function (n) {
                return n;
            }
        }
    }
}
</script>

