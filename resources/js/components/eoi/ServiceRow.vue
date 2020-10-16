<template>
    <tr>
        <ValidationProvider tag="td" name="service[]" rules="required"
                            v-slot="{ errors }">
            <v-select label="name" placeholder="Select Service Type"
                      v-model="service.service_id" :reduce="s => s.id" :options="services">
            </v-select>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>
        <ValidationProvider tag="td" name="Name of Low income areas[]" rules="required"
                            v-slot="{ errors }">
            <input type="text" v-model="service.areas" class="form-control">
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>

        <ValidationProvider tag="td" name="Total No[]" rules="required|numeric"
                            v-slot="{ errors }">
            <vue-numeric separator="," v-model="service.total" class="form-control"></vue-numeric>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>
        <td>
            <button type="button" class="btn btn-sm btn-primary" @click="$emit('add')">
                <span class="fa fa-plus"></span>
            </button>
            <button type="button" class="btn btn-sm btn-danger" @click="$emit('remove')">
                <span class="fa fa-minus"></span>
            </button>
        </td>
    </tr>
</template>

<script>
export default {
    name: "ServiceRow",
    props: {
        services: {required: true, type: Array},
        service: {required: true, type: Object},
    }
}
</script>
