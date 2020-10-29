<template>
    <ValidationObserver v-slot="{ handleSubmit }">
        <div v-html="$error.handle(error)"></div>
        <form @submit.prevent="handleSubmit(onSubmit)" class="col-md-12 mt-1">
            <table class="table">
                <thead>
                <tr>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Monthly Grant Multiplier</th>
                    <th></th>
                </tr>
                </thead>
                <tr is="mgm-row"
                    v-for="(d, index) in mgm.mgms"
                    @add="addMgm"
                    @remove="removeMgm(index)"
                    :mgm="d"
                    v-bind:key="index"
                    :index="index"/>
            </table>
            <button class="btn btn-warning" v-if="loading" type="submit">
                Submitting <i class="feather icon-loader"></i>
            </button>
            <button class="btn btn-info" v-else type="submit">
                Save <i class="feather icon-check-circle"></i>
            </button>
        </form>
    </ValidationObserver>
</template>

<script>

import MgmRow from "./MgmRow";

export default {
    name: "MgmForm",
    components: {
        MgmRow
    },
    props: {
        submitUrl: {required: true, type: String},
    },
    data() {
        return {
            error: '',
            mgm: {
                mgms: [
                    {month: 10, year: 2020, amount: null},
                    {month: 11, year: 2020, amount: null},
                    {month: 12, year: 2020, amount: null}
                ]
            },
            loading: false
        };
    },
    methods: {
        onSubmit() {
            this.loading = true;
            axios.post(this.submitUrl, this.mgm).then(response => {
                this.$toastr.s(response.data.message, "Success");
                location.reload();
            }).catch(error => {
                this.error = error.response;
            }).finally(() => {
                this.loading = false;
            });
        },
        addMgm() {
            this.mgm.mgms.push({month: 12, year: 2020, amount: null});
        },
        removeMgm(index) {
            if (this.mgm.mgms.length > 1) {
                this.mgm.mgms.splice(index, 1);
            }
        },
    }
}
</script>
