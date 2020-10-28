<template>
    <tr>
        <ValidationProvider tag="td" name="Covid 19 Emergency intervention[]" rules="required"
                            v-slot="{ errors }">
            <v-select v-model="item.emergency_intervention" :options="services">
            </v-select>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>
        <ValidationProvider tag="td" name="Potential Risks[]" rules="required"
                            v-slot="{ errors }">
            <v-select v-model="item.risks" :options="risks">
            </v-select>
            <textarea v-if="item.risks=='Other'" required v-model="item.other_risk" class="form-control"></textarea>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>

        <ValidationProvider tag="td" name="Potential Mitigation Measures" rules="required"
                            v-slot="{ errors }">
            <v-select v-model="item.mitigation" multiple :options="mitigation">
            </v-select>
            <textarea v-if="item.mitigation.includes('Other')" required v-model="item.other_mitigation" class="form-control"></textarea>
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
        services: {required: true, type: Array},
        risks: {required: true, type: Array},
        mitigation: {required: true, type: Array}
    },
    computed:{
        other_mitig(){
            return this.mitigation.find('Other')
        }
    }
}
</script>
