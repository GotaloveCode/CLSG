<template>
    <div>
        <div v-html="$error.handle(error)"/>
        <template v-if="show">
            <view-cslg-calculation :cslg="cslg"></view-cslg-calculation>
        </template>
        <div v-if="!show">
            <form @submit.prevent="postData()">
               <div class="row">
                   <div class="col-md-6">
                   <div class="card" style="width: 95%">
                       <div class="card-header">
                           <h4>Verified amount of revenues collected during in the month (KES)</h4>
                       </div>
                       <div class="card-content collapse show">
                           <div class="card-body" style="padding-top: 0">
                            <div class="form-group">
                                <label>Amount</label>
                                <vue-numeric separator="," class="form-control" required v-model="operations.revenue" required></vue-numeric>
                            </div>
                            <div class="form-group">
                                <label>Comment</label>
                                <textarea  class="form-control" v-model="form.revenues_comment" required></textarea>

                            </div>
                    </div>
                           </div>
                       </div>
                   </div>

                   <div class="col-md-6">
                   <div class="card" style="width: 95%">
                       <div class="card-header">
                           <h4>Grant Multiplier for this month (as per CLSG Agreement)</h4>
                       </div>
                       <div class="card-content collapse show">
                           <div class="card-body" style="padding-top: 0">
                    <div class="form-group">
                        <label>Amount</label>
                        <vue-numeric separator="," class="form-control" required v-model="grant" required></vue-numeric>
                    </div>
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea  class="form-control" v-model="form.grant_multiplier_comment" required></textarea>
                    </div>
            </div>
                           </div></div></div>
               </div>
                <div class="row">
                    <div class="col-md-6">
                    <div class="card" style="height: 95%">
                        <div class="card-header">
                            <h4>Gross CLSG Amount (KES)</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body" style="padding-top: 0">
                    <div class="form-group">
                        <label>Amount</label>
                        <vue-numeric separator="," class="form-control" required v-model="operations.clsg_total" required></vue-numeric>
                    </div>
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea  class="form-control" v-model="form.cslg_gross_comment" required></textarea>
                    </div>
            </div>
                            </div></div>
                    </div>

                    <div class="col-md-6">
                    <div class="card" style="height: 95%">
                        <div class="card-header">
                            <h4>Gross CLSG Amount (KES)</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body" style="padding-top: 0">
                    <div class="form-group">
                        <label>Performance Adjusted- CLSG %</label>
                        <vue-numeric separator="," class="form-control" required v-model="form.cslg_adjusted_amount" required></vue-numeric>
                    </div>
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea  class="form-control" v-model="form.cslg_adjusted_comment" required></textarea>
                    </div>
            </div>

                </div>
                        </div></div>
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
    props:{
        cslg:{type: [Object,Array]},
        operations:{type: Object},
        grant:{type: Number},
    },
    data() {
        return {
            error: '',
            form: {
                revenues:0,
                revenues_comment:'',
                grant_multiplier_amount:0,
                grant_multiplier_comment:'',
                cslg_gross_amount:0,
                cslg_gross_comment:'',
                cslg_adjusted_amount:100,
                cslg_adjusted_comment:'',
                status:'Pending',
            },
            loading: false,
            show: false
        }
    },
    created() {
        console.log(this.services)
       this.setUp();
    },
    methods: {
        setUp(){
            if (this.cslg.id !=undefined){
                this.show = true;
            }
        },

        postData() {
            this.error = '';
            this.loading = true;
            axios.post("/reports/cslg-calculation", this.form).then(() => {
                window.location.href = "/reports/cslg-calculation-list"
            }).catch(error => {
                this.error = error.response;
            });

        },

    },
    components: {
        ViewCslgCalculation
    }
}
</script>

