<template>
    <tr>
        <ValidationProvider tag="td" name="Connection[]" rules="required"
                            v-slot="{ errors }">
            <v-select label="name" placeholder="Select Connection Type"
                      v-model="connection.connection_id" :reduce="s => s.id" :options="connections">
            </v-select>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>
        <ValidationProvider tag="td" name="Name of Low income areas[]" rules="required"
                            v-slot="{ errors }">
            <input type="text" v-model="connection.areas" class="form-control">
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>

        <ValidationProvider tag="td" name="Total No[]" rules="required|numeric"
                            v-slot="{ errors }">
            <vue-numeric separator="," v-model="connection.total" class="form-control"></vue-numeric>
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
    name: "ConnectionRow",
    props: {
        connections: {required: true, type: Array},
        connection: {required: true, type: Object},
    }
}
</script>
