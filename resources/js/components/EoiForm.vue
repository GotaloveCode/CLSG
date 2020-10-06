<template>
    <form class="row" @submit.prevent="validateForm()">
        <div class="col-md-6">
            <div class="row form-group" :class="{ 'has-feedback has-error': errors.has('program_manager')}">
                <label class="control-label col-md-4">Program Manager</label>
                <input type="text" v-validate="'required'" v-model="program_manager" name="program_manager" class="form-control col-md-8">
            </div>
            <div class="row form-group" :class="{ 'has-feedback has-error': errors.has('fixed_grant')}">
                <label class="control-label col-md-4">Fixed Grant</label>
                <input type="text" name="fixed_grant" v-validate="'required'" v-model="fixed_grant" class="form-control col-md-8">
            </div>
            <div class="row form-group" :class="{ 'has-feedback has-error': errors.has('last_name')}">
                <label class="control-label col-md-4">Estimated Variable
                    Grant</label>
                <input type="text" name="variable_grant" v-validate="'required'" v-model="program_manager" class="form-control col-md-8">
            </div>
            <div class="row form-group">
                <label class="control-label col-md-4">Total</label>
                <input type="text" name="total" v-validate="'required'" v-model="program_manager" readonly class="form-control col-md-8">
            </div>
        </div>
        <div class="col-md-6">
            <p>Total Funding will be used as indicated:</p>
            <div class="row form-group" :class="{ 'has-feedback has-error': errors.has('last_name')}">
                <label class="control-label col-md-6">1. Short-term
                    COVID-19 emergency interventions</label>
                <input type="text" name="emergency_intervention" v-validate="'required'" v-model="program_manager" class="form-control col-md-6">
            </div>
            <div class="row form-group" :class="{ 'has-feedback has-error': errors.has('last_name')}">
                <label class="control-label col-md-6">2. Operation & Maintenance
                    Costs </label>
                <input type="text" name="operation_costs" v-validate="'required'" v-model="program_manager" class="form-control col-md-6">
            </div>
        </div>
        <hr>
        <p class="col-md-12">The company serves low income areas as detailed in the table below</p>
        <table class="table">
            <thead>
            <tr>
                <th>Population Served</th>
                <th>Name of Low Income Areas</th>
                <th>Total No of People Served</th>
            </tr>
            </thead>
            <tr>
                <td>Water Services</td>
                <td>
                    <textarea name="water_service_areas" id="water_service_areas" class="form-control"
                                              rows="3"></textarea>
                </td>
                <td><input type="number" class="form-control" v-validate="'required'" v-model="program_manager" name="total_people_water_served"></td>
            </tr>
            <tr>
                <td>Proportion of low income population served</td>
                <td><input type="number" class="form-control" v-validate="'required'" v-model="program_manager" placeholder="%" name="proportion_served">
                </td>
            </tr>
        </table>
    </form>
</template>

<script>
export default {
    data() {
        return {
            bid_bond: {
                company: null
            },
            step: 1,
            error: '',
            pricing: {},
            companies: [],
            show_summary: false
        }
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
