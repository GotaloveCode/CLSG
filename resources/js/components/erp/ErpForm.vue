<template>
    <ValidationObserver v-slot="{ handleSubmit }">
        <div v-html="$error.handle(error)"/>
        <form class="form" @submit.prevent="handleSubmit(onSubmit)">
            <div class="form-body row">
                <ValidationProvider name="ERP Coordinator" rules="required" v-slot="{ errors }"
                                    class="col-md-4 form-group">
                    <label>ERP Coordinator</label>
                    <input v-model="erp.coordinator" type="text" class="form-control"/>
                    <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                </ValidationProvider>
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
                        v-bind:key="index"
                        :index="index"></tr>
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

export default {
    name: "ErpForm",
    components: {
        ItemRow
    },
    props: {
        wsp_id: {required: true, type: String},
        submitUrl: {required: true, type: String},
        interventions: {required: true, type: Array},
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
        }
    }),
    created() {
        if (this.interventions.length) {
            this.initItems();
        }
    },
    methods: {
        onSubmit() {
            this.error = '';
            axios.post(this.submitUrl, this.erp).then(response => {
                this.$toastr.s(response.data.message);
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
                emergency_intervention: ''
            });
        },
        removeItem(index) {
            if (this.erp.items.length > 1) {
                this.erp.items.splice(index, 1);
            }
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
                    emergency_intervention: x.name
                });
            });
            this.erp.items = items;
        }
    }
}
</script>
