<template>
    <tr>
        <ValidationProvider tag="td" name="Activity[]" rules="required"
                            v-slot="{ errors }">
            <v-select label="name" placeholder="Select Activity"
                      v-model="objective.id" :reduce="s => s.id" :options="objectives">
            </v-select>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>
        <ValidationProvider tag="td" name="Expected Outcome[]" rules="required"
                            v-slot="{ errors }">
            <input type="text" v-model="objective.areas" class="form-control">

            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>

        <ValidationProvider tag="td" name="Total No[]" rules="required|numeric"
                            v-slot="{ errors }">
            <vue-numeric separator="," v-model="objective.total" class="form-control"></vue-numeric>
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
    name: "BcpRow",
    props: {
        objectives: {required: true, type: Array},
        objective: {required: true, type: Object},
    },
}
</script>
