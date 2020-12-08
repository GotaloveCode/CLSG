<template>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Item</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tr>
                <td>Verified amount of revenues collected during in the month (KES) :</td>
                <td>{{ $number.format(operations.revenue) }}</td>
            </tr>
            <tr>
                <td>Grant Multiplier for this month (as per CLSG Agreement) :</td>
                <td><span class="form-control-static" v-text="grant"></span></td>
            </tr>
            <tr>
                <td>Actual Performance Score (%) :</td>
                <td><span class="form-control-static" v-text="score"></span>%</td>
            </tr>
            <tr>
                <td>Performance Adjustment (%) :</td>
                <td><span class="form-control-static" v-text="form.cslg_adjusted_amount"></span>%</td>
            </tr>
            <tr>
                <td>Fixed Grant :</td>
                <td> {{ $number.format(costs) }}</td>
            </tr>
            <tr>
                <td>Gross CLSG Amount (KES)</td>
                <td>
                    {{ $number.format(monthly_clsg) }}
                </td>
            </tr>
        </table>
    </div>
</template>

<script>

export default {
    props: {
        cslg: {type: [Object, Array]},
        operations: {type: Object},
        grant: {type: Number},
        score: {type: Number},
    },
    data() {
        return {
            form: {
                revenues: 0,
                grant_multiplier_amount: 0,
                cslg_gross_amount: 0,
                cslg_adjusted_amount: 100,
                status: 'Pending',
            }
        }
    },
    mounted() {
        this.setUp();
    },
    methods: {
        setUp() {
            if (this.score >= 70) {
                this.form.cslg_adjusted_amount = 100;
            }
            if (this.cslg.id != undefined) {
                this.show = true;
            }
        }
    },
    computed: {
        costs() {
            return this.operations.status_of_covid_implementation.reduce((a, b) => a + parseInt(b.cost), 0);
        },
        monthly_clsg() {
            //TODO: check against budgeted maximum variable grant
            //Fixed Grant + (Variable Grant * Performance Adjustment(%))
            return this.costs + (this.operations.revenue * this.form.cslg_adjusted_amount / 100)
        }
    }
}
</script>

