<template>
    <tr>
        <ValidationProvider tag="td" name="cost[]" rules="required"
                            v-slot="{ errors }">
            <v-select name="cost" label="name" placeholder="Select cost Type"
                      v-model="cost.estimatedcost_id" :reduce="s => s.id" :options="costs">
            </v-select>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>
        <ValidationProvider tag="td" name="Unit cost[]" rules="required|numeric"
                            v-slot="{ errors }">
            <vue-numeric separator="," :precision="2" v-model="cost.unit" class="form-control"></vue-numeric>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>

        <ValidationProvider tag="td" name="Quantity[]" rules="required|numeric"
                            v-slot="{ errors }">
            <vue-numeric separator="," :precision="2" v-model="cost.quantity" class="form-control"></vue-numeric>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>

        <ValidationProvider tag="td" name="Total[]" rules="required|numeric"
                            v-slot="{ errors }">
            <vue-numeric separator="," disabled="true" v-model="cost.total" class="form-control"></vue-numeric>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>
        <td>
            <button type="button" class="btn btn-sm btn-primary" @click="$emit('add')">
                <span class="feather icon-plus"></span>
            </button>
            <button type="button" class="btn btn-sm btn-danger" @click="$emit('remove')">
                <span class="feather icon-minus"></span>
            </button>
        </td>
    </tr>
</template>

<script>
export default {
    name: "EstimatedCostRow",
    props: {
        costs: {required: true, type: Array},
        cost: {required: true, type: Object},
    },
    watch: {
        'cost.quantity': function () {
            this.sum();
        },
        'cost.unit': function () {
            this.sum();
        }
    },
    methods: {
        sum() {
            this.cost.total = this.cost.quantity * this.cost.unit;
        }
    }
}
</script>
