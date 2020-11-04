<template>
    <div>
        <form @submit.prevent="approveClg()">
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
                                    <vue-numeric separator="," class="form-control" required v-model="form.revenues" required :disabled="approved"></vue-numeric>
                                </div>
                                <div class="form-group">
                                    <label>Comment</label>
                                    <textarea  class="form-control" v-model="form.revenues_comment" required :disabled="approved"></textarea>

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
                                    <vue-numeric separator="," class="form-control" required v-model="form.grant_multiplier_amount" required :disabled="approved"></vue-numeric>
                                </div>
                                <div class="form-group">
                                    <label>Comment</label>
                                    <textarea  class="form-control" v-model="form.grant_multiplier_comment" required :disabled="approved"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="width: 95%">
                        <div class="card-header">
                            <h4>Gross CLSG Amount (KES)</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body" style="padding-top: 0">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <vue-numeric separator="," class="form-control" required v-model="form.cslg_gross_amount" required :disabled="approved"></vue-numeric>
                                </div>
                                <div class="form-group">
                                    <label>Comment</label>
                                    <textarea  class="form-control" v-model="form.cslg_gross_comment" required :disabled="approved"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="width: 95%">
                        <div class="card-header">
                            <h4>Performance Adjusted- CLSG Amount (KES)</h4>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body" style="padding-top: 0">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <vue-numeric separator="," class="form-control" required v-model="form.cslg_adjusted_amount" required :disabled="approved"></vue-numeric>
                                </div>
                                <div class="form-group">
                                    <label>Comment</label>
                                    <textarea  class="form-control" v-model="form.cslg_adjusted_comment" required :disabled="approved"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-center" v-if="cslg.status=='Pending'">
                <button type="submit" class="btn btn-secondary"><i class="fa fa-check" aria-hidden="true"> Approve</i>
                </button>
            </div>
        </form>
    </div>
</template>

<script>

export default {
    props:{
        cslg:{type: [Object,Array]},
        operations:{type: Object}
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
                cslg_adjusted_amount:0,
                cslg_adjusted_comment:''
            },
            loading: false,
            show: false,
            approved:false
        }
    },
    created() {
        this.setUp();
    },
    methods: {
        viewFile(filename){
            window.location.href = "/reports/wsp-reporting-attachments/"+filename;
        },
        setUp(){
            this.form = this.cslg;
            if (this.cslg.status =="Approved") this.approved = true;
        },
        goBack(){
            window.location.href = "/reports/cslg-calculation-list";
        },
        approveClg(){
            this.form.id = this.cslg.id;
            this.form.status = "Approved";
            console.log(this.form)
            axios.post("/reports/cslg-calculation/approve",this.form)
            .then(res => {
                console.log("success")
            })
        }
    },

}
</script>


