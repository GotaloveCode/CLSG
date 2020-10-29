<template>
    <ValidationObserver v-slot="{ handleSubmit }">
        <div v-html="$error.handle(error)"/>
        <div class="alert alert-info alert-dismissible mb-2" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            The ERP is a component of the BCP. Make sure you fill in the BCP first.
        </div>
        <form class="form" @submit.prevent="handleSubmit(onSubmit)">
            <div class="form-body row">
                <ValidationProvider name="ERP Coordinator" rules="required" v-slot="{ errors }"
                                    class="col-md-4 form-group">
                    <label>ERP Coordinator</label>
                    <input v-model="erp.coordinator" type="text" class="form-control"/>
                    <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                </ValidationProvider>
                <h5 class="col-md-12">Breakdown of short-term COVID-19 related emergency interventions</h5>
                <table class="table">
                    <thead>
                    <tr>
                        <td>COVID-19 Emergency Intervention</td>
                        <td>Potential risks</td>
                        <td>Potential Mitigation Measures</td>
                        <td colspan="2">Resource Requirement</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Cost(KSHS)</td>
                        <td>Others</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tr is="item-row" v-for="(d, index) in erp.items"
                        @add="addItem"
                        @remove="removeItem(index)"
                        :item="d"
                        :services="services"
                        :risks="risks"
                        :mitigation="mitigation"
                        v-bind:key="index"
                        :index="index"></tr>
                </table>
                <h5 class="col-md-12">Breakdown of O&M estimated costs:</h5>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Type of Service/item</th>
                        <th>Cost (KES)</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tr is="operation-cost-row"
                        v-for="(d, index) in erp.operation_costs"
                        @add="addCost"
                        @remove="removeCost(index)"
                        :operations="operationCosts"
                        :operation="d"
                        v-bind:key="index"
                        :index="index"/>
                </table>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-check-square-o"></i> Save
                </button>
            </div>
        </form>
    </ValidationObserver>
</template>

<script>
import ItemRow from "./ItemRow";
import OperationCostRow from "../eoi/OperationCostRow";

export default {
    name: "ErpForm",
    components: {
        ItemRow,
        OperationCostRow
    },
    props: {
        wsp_id: {required: true, type: String},
        submitUrl: {required: true, type: String},
        interventions: {required: true, type: Array},
        existingErp: {required: false, type: Object},
        operationCosts: {required: true, type: Array},
        eoiOperations: {required: false, type: Array},
        services: {required: true, type: Array},
        risks: {required: true, type: Array},
        mitigation: {required: true, type: Array},
    },
    mounted() {
        this.initOperations();
        if (this.interventions.length) {
            this.initItems();
        }
        this.setWspId();
        if (this.existingErp) {
            this.initErp();
        }
    },
    data: () => ({
        error: '',
        erp: {
            wsp_id: null,
            coordinator: '',
            items: [{
                cost: 0,
                other: '',
                mitigation: '',
                risks: '',
                emergency_intervention: ''
            }],
            operation_costs: [{cost: null, operationcost_id: null}],
        }
    }),
    methods: {
        setWspId() {
            this.erp.wsp_id = this.wsp_id;
        },
        initErp() {
            this.erp.coordinator = this.existingErp.coordinator;
            this.erp.items = [];
            this.existingErp.erp_items.forEach(s => {
                this.erp.items.push({
                    cost: s.cost,
                    other: s.other,
                    mitigation: s.mitigation,
                    risks: s.risks,
                    emergency_intervention: s.emergency_intervention,
                    other_risk:'',
                    other_mitigation:'',
                });
            });
            this.erp.operation_costs = [];
            this.existingErp.operation_costs.forEach(x => {
                this.erp.operation_costs.push({
                    cost: x.pivot.cost,
                    operationcost_id: x.pivot.operationcost_id,
                });
            });
        },

        onSubmit() {
            this.error = '';
            this.existingErp ? this.updateData() : this.postData();
        },
        postData() {
            axios.post(this.submitUrl, this.erp).then(response => {
                this.$toastr.s("ERP created successfully!");
                location.href = "/erps/" + response.data.id + "/attachments"
            }).catch(error => {
                this.error = error.response;
            });
        },
        updateData() {
            axios.put(this.submitUrl, this.erp).then(() => {
                this.$toastr.s("ERP updated successfully!");
                location.href = "/erps/" + response.data.id + "/attachments"
            }).catch(error => {
                this.error = error.response;
            });
        },
        addItem() {
            this.erp.items.push({
                cost: 0,
                other: '',
                mitigation: '',
                risks: '',
                emergency_intervention: '',
                other_risk:'',
                other_mitigation:'',
            });
        },
        removeItem(index) {
            if (this.erp.items.length > 1) {
                this.erp.items.splice(index, 1);
            }
        },
        initOperations() {
            let items = []
            this.erp.operation_costs = [];
            this.eoiOperations.forEach(x => {
                items.push({
                    cost: x.pivot.cost,
                    operationcost_id: x.pivot.operationcost_id,
                });
            });
            this.erp.operation_costs = items;
        },
        initItems() {
            this.erp.wsp_id = this.wsp_id;
            let items = []
            this.interventions.forEach(x => {
                items.push({
                    cost: x.pivot.total,
                    other: '',
                    mitigation: '',
                    risks: '',
                    emergency_intervention: x.name,
                    other_risk:'',
                    other_mitigation:'',
                });
            });
            this.erp.items = items;
        },
        addCost() {
            this.erp.operation_costs.push({cost: null, operationcost_id: null});
        },
        removeCost(index) {
            if (this.erp.operation_costs.length > 1) {
                this.erp.operation_costs.splice(index, 1);
            }
        }
    }
}
</script>
