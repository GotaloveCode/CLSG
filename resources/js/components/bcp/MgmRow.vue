<template>
    <tr>
        <ValidationProvider tag="td" name="Month[]" rules="required"
                            v-slot="{ errors }">
            <v-select label="name" placeholder="Select Month"
                      v-model="mgm.month" :options="months">
            </v-select>
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>
        <ValidationProvider tag="td" name="Year[]" rules="required|numeric|min_value:2020"
                            v-slot="{ errors }">
            <input type="text" v-model="mgm.year" class="form-control">
            <span class="text-danger">{{ errors[0] }}</span>
        </ValidationProvider>

        <ValidationProvider tag="td" name="Amount[]" rules="required|decimal"
                            v-slot="{ errors }">
            <input type="text" placeholder="eg. 0.6" v-model="mgm.amount" class="form-control"/>
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
import {extend} from 'vee-validate';

extend("decimal", {
    validate: (value, {decimals = '*', separator = '.'} = {}) => {
        if (value === null || value === undefined || value === '') {
            return {
                valid: false
            };
        }
        if (Number(decimals) === 0) {
            return {
                valid: /^-?\d*$/.test(value),
            };
        }
        const regexPart = decimals === '*' ? '+' : `{1,${decimals}}`;
        const regex = new RegExp(`^[-+]?\\d*(\\${separator}\\d${regexPart})?([eE]{1}[-]?\\d+)?$`);

        return {
            valid: regex.test(value),
        };
    },
    message: 'The {_field_} field must contain only decimal values'
});
export default {
    name: "MgmRow",
    props: {
        mgm: {required: true, type: Object},
    },
    data: () => ({
        months: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
    }),
}
</script>
