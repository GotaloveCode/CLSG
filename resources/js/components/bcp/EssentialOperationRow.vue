<template>
    <tr>
        <ValidationProvider tag="td" name="Priority level[]" rules="required"
                            v-slot="{ errors }">
            <v-select :options="['High','Low']" v-model="operation.priority_level"></v-select>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>
        <ValidationProvider tag="td" name="Essential Function[]" rules="required"
                            v-slot="{ errors }">
            <v-select label="name" placeholder="Select Essential Function"
                      v-model="operation.essentialfunction_id" :reduce="s => s.id" :options="essential_functions">
            </v-select>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>

        <ValidationProvider tag="td" name="Primary Staff[]" rules="required"
                            v-slot="{ errors }">
            <v-select label="name" placeholder="Select Primary Staff" v-model="operation.primary_staff"
                      data-toggle="tooltip" :reduce="c =>c.id"
                      title="Add primary staff first for them to appear here"
                      :options="primary_staff"></v-select>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>
        <ValidationProvider tag="td" name="Backup Staff[]" rules="required"
                            v-slot="{ errors }">
            <v-select label="name" placeholder="Select Backup Staff" :options="backup_staff" data-toggle="tooltip"
                      title="Add backup staff first for them to appear here" :reduce="c =>c.id"
                      v-model="operation.backup_staff">
            </v-select>
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
    name: "EssentialOperationRow",
    props: {
        staff: {required: true, type: Array},
        essential_functions: {required: true, type: Array},
        operation: {required: true, type: Object},
    },
    computed: {
        primary_staff() {
            return this.staff.filter(x => x.type === 'Essential');
        },
        backup_staff() {
            return this.staff.filter(x => x.type === 'Backup');
        },
    }
}
</script>
