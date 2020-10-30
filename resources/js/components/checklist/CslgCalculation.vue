<template>
    <div>
        <div v-html="$error.handle(error)"/>
        <template v-if="show">
            <view-cslg-calculation :cslg="cslg"></view-cslg-calculation>
        </template>
        <div v-if="!show">
            <form @submit.prevent="postData()">

                <div class="row">
                    <h4 class="text-uppercase col-md-12 text-center">CLSG calculation</h4>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">

                        <fieldset class="the-fieldset">
                            <legend class="the-legend"><label class="fyr">Verified amount of revenues collected during in the month (KES)</label></legend>
                            <div class="form-group">
                                <label>Amount</label>
                                <vue-numeric separator="," class="form-control" required v-model="form.revenues" required></vue-numeric>
                            </div>
                            <div class="form-group">
                                <label>Comment</label>
                                <textarea  class="form-control" v-model="form.revenues_comment" required></textarea>

                            </div>
                        </fieldset>
                    </div>
           <div class="col-md-6">
                <fieldset class="the-fieldset">
                    <legend class="the-legend"><label class="fyr">Grant Multiplier for this month (as per CLSG Agreement)</label></legend>
                    <div class="form-group">
                        <label>Amount</label>
                        <vue-numeric separator="," class="form-control" required v-model="form.grant_multiplier_amount" required></vue-numeric>
                    </div>
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea  class="form-control" v-model="form.grant_multiplier_comment" required></textarea>
                    </div>
                </fieldset>
            </div>
               <div class="col-md-6">
                   <br>
                <fieldset class="the-fieldset">
                    <legend class="the-legend"><label class="fyr">Gross CLSG Amount (KES)</label></legend>
                    <div class="form-group">
                        <label>Amount</label>
                        <vue-numeric separator="," class="form-control" required v-model="form.cslg_gross_amount" required></vue-numeric>
                    </div>
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea  class="form-control" v-model="form.cslg_gross_comment" required></textarea>
                    </div>
                </fieldset>
            </div>
              <div class="col-md-6">
                  <br>
                <fieldset class="the-fieldset">
                    <legend class="the-legend"><label class="fyr">Performance Adjusted- CLSG Amount (KES)</label></legend>
                    <div class="form-group">
                        <label>Amount</label>
                        <vue-numeric separator="," class="form-control" required v-model="form.cslg_adjusted_amount" required></vue-numeric>
                    </div>
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea  class="form-control" v-model="form.cslg_adjusted_comment" required></textarea>
                    </div>
                </fieldset>
            </div>

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
        cslg:{type: [Object,Array]}
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

<style>
.the-legend {
    border-style: none;
    border-width: 0;
    font-size: 14px;
    line-height: 20px;
    margin-bottom: 0;
    width: auto;
    padding: 0 10px;
    border: 1px solid #e0e0e0;
}
.the-fieldset {
    border: 1px solid #e0e0e0;
    padding: 10px;
}
.fyr{
    font-weight:800
}
.ml-10{
    margin-left: 10px;
}
.mt-5{
    margin-top: 5px;
}
.fs-20{
    font-size: 20px;
}
</style>
