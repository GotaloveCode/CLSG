<template>
    <tr>
        <ValidationProvider tag="td" name="Month[]" rules="required"
                            v-slot="{ errors }">
            <v-select label="name" placeholder="Select Month"
                      v-model="revenue.month" :options="months">
            </v-select>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>
        <ValidationProvider tag="td" name="Year[]" rules="required|numeric|min_value:2020"
                            v-slot="{ errors }">
            <input type="text" v-model="revenue.year" class="form-control">
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>

        <ValidationProvider tag="td" name="Amount[]" rules="required|numeric|min_value:1"
                            v-slot="{ errors }">
            <vue-numeric separator="," v-model="revenue.amount" class="form-control"></vue-numeric>
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
    name: "RevenueRow",
    props: {
        revenue: {required: true, type: Object},
    },
    data: () => ({
        months: [1,2,3,4,5,6,7,8,9,10,11,12],
    }),
}
</script>
