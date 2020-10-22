<template>
    <tr>
        <ValidationProvider tag="td" name="Operation Cost[]" rules="required"
                            v-slot="{ errors }">
            <v-select name="operation" label="name" placeholder="Select Operation Cost"
                      v-model="operation.operationcost_id" :reduce="s => s.id" :options="operations">
            </v-select>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>

        <ValidationProvider tag="td" name="Unit Rate[]" rules="required|numeric"
                            v-slot="{ errors }">
            <vue-numeric separator="," :precision="2" v-model="operation.unit_rate" class="form-control"></vue-numeric>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>
        <ValidationProvider tag="td" name="Total[]" rules="required|numeric"
                            v-slot="{ errors }">
            <vue-numeric separator="," v-model="operation.total" class="form-control"></vue-numeric>
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
    name: "OperationCostRow",
    props: {
        operations: {required: true, type: Array},
        operation: {required: true, type: Object},
    }
}
</script>
