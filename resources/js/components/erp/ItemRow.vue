<template>
    <tr>
        <ValidationProvider tag="td" name="Covid 19 Emergency intervention[]" rules="required"
                            v-slot="{ errors }">
            <input type="text" v-model="item.emergency_intervention" class="form-control"/>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>
        <ValidationProvider tag="td" name="Potential Risks[]" rules="required"
                            v-slot="{ errors }">
            <textarea v-model="item.risks" class="form-control" placeholder=" eg. Vandalism by beneficiaries"></textarea>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>

        <ValidationProvider tag="td" name="Potential Mitigation Measures" rules="required"
                            v-slot="{ errors }">
            <textarea v-model="item.mitigation" class="form-control" placeholder="eg. Partner with local administration to provide security"></textarea>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>
        <ValidationProvider tag="td" name="Cost[]" rules="required|numeric"
                            v-slot="{ errors }">
            <vue-numeric separator="," v-model="item.cost" class="form-control"></vue-numeric>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>
        <ValidationProvider tag="td" name="Others[]" rules="required"
                            v-slot="{ errors }">
            <textarea v-model="item.other" class="form-control"></textarea>
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
    name: "ItemRow",
    props: {
        item: {required: true, type: Object},
    },
}
</script>
