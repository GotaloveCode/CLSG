<template>
    <div>
        <div v-html="$error.handle(error)"/>
        <template v-if="show">
            <view-cslg-calculation :cslg="cslg"></view-cslg-calculation>
        </template>
        <div v-if="!show">
            <form @submit.prevent="postData()">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>Amount</th>
                            <th>Comment</th>
                        </tr>
                        </thead>
                        <tr>
                            <td>Verified amount of revenues collected during in the month (KES) :</td>
                            <td>{{ $number.format(operations.revenue) }}</td>
                            <td>
                               <textarea class="form-control" v-model="form.revenues_comment"
                                         required></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Grant Multiplier for this month (as per CLSG Agreement) :</td>
                            <td><span class="form-control-static" v-text="grant"></span></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Actual Performance Score (%) :</td>
                            <td><span class="form-control-static" v-text="score"></span>%</td>
                            <td>
                                <textarea class="form-control" v-model="form.grant_multiplier_comment"
                                          required></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Performance Adjustment (%) :</td>
                            <td><span class="form-control-static" v-text="form.cslg_adjusted_amount"></span>%</td>
                            <td>
                                <textarea class="form-control" v-model="form.cslg_adjusted_comment"
                                          required></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>Fixed Grant :</td>
                            <td> {{ $number.format(costs) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Gross CLSG Amount (KES)</td>
                            <td>
                                {{ $number.format(monthly_clsg) }}
                            </td>
                            <td>
                                 <textarea class="form-control" v-model="form.cslg_gross_comment"
                                           required></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="form-group text-center" style="margin-top: 2%">
                    <button class="btn btn-warning" v-if="loading" type="button">Sending ... <i
                        class="feather icon-loader"></i></button>
                    <button type="submit" v-else class="btn btn-primary">
                        Submit <i class="feather icon-send"></i>
                    </button>

                </div>
            </form>
        </div>
    </div>
</template>

<script>
import ViewCslgCalculation from "./ViewCslgCalculation";

export default {
    components: {
        ViewCslgCalculation
    },
    props: {
        cslg: {type: [Object, Array]},
        operations: {type: Object},
        grant: {type: Number},
        score: {type: Number},
    },
    data() {
        return {
            error: '',
            form: {
                revenues: 0,
                revenues_comment: '',
                grant_multiplier_amount: 0,
                grant_multiplier_comment: '',
                cslg_gross_amount: 0,
                cslg_gross_comment: '',
                cslg_adjusted_amount: 100,
                cslg_adjusted_comment: '',
                status: 'Pending',
            },
            loading: false,
            show: false
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
        },

        postData() {
            this.computeValues();
            this.error = '';
            this.loading = true;
            axios.post("/cslg-calculation", this.form).then(() => {
                window.location.href = "/cslg-calculation"
            }).catch(error => {
                this.error = error.response;
            });

        },
        computeValues() {
            this.form.revenues = this.operations.revenue;
            this.form.grant_multiplier_amount = this.grant;
            this.form.cslg_gross_amount = this.operations.clsg_total;
        }
    },
    computed: {
        costs() {
            return this.operations.operations_costs.reduce((a, b) => a + b.amount,0);
        },
        monthly_clsg(){
            //TODO: check against budgeted maximum variable grant
            //Fixed Grant + (Variable Grant * Performance Adjustment(%))
            return this.costs + (this.operations.revenue * this.form.cslg_adjusted_amount/100)
        }
    }
}
</script>

