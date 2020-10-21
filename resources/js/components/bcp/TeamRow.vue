<template>
    <tr>
        <ValidationProvider tag="td" name="Name[]" rules="required"
                            v-slot="{ errors }">
            <input type="text" placeholder="full name" v-model="team.name" class="form-control">
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>
        <ValidationProvider tag="td" name="Role[]" rules="required"
                            v-slot="{ errors }">
            <input type="text" placeholder="eg. designated BCP coordinator" v-model="team.role" class="form-control">
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>

        <ValidationProvider tag="td" name="Unit[]" rules="required"
                            v-slot="{ errors }">
            <input type="text" placeholder="eg. Supply Department" v-model="team.unit" class="form-control">
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
    name: "TeamRow",
    props: {
        team: {required: true, type: Object},
    }
}
</script>
