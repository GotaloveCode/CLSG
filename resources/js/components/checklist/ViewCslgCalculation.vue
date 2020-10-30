<template>
    <div>
            <form>

                <div class="row">
                    <h4 class="text-uppercase col-md-12 text-center">CLSG Calculation</h4>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">

                        <fieldset class="the-fieldset">
                            <legend class="the-legend"><label class="fyr">Verified amount of revenues collected during in the month (KES)</label></legend>
                            <div class="form-group">
                                <label>Amount</label>
                                <vue-numeric separator="," class="form-control" required v-model="form.revenues" required disabled></vue-numeric>
                            </div>
                            <div class="form-group">
                                <label>Comment</label>
                                <textarea  class="form-control" v-model="form.revenues_comment" required disabled></textarea>

                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <fieldset class="the-fieldset">
                            <legend class="the-legend"><label class="fyr">Grant Multiplier for this month (as per CLSG Agreement)</label></legend>
                            <div class="form-group">
                                <label>Amount</label>
                                <vue-numeric separator="," class="form-control" required v-model="form.grant_multiplier_amount" required disabled></vue-numeric>
                            </div>
                            <div class="form-group">
                                <label>Comment</label>
                                <textarea  class="form-control" v-model="form.grant_multiplier_comment" required disabled></textarea>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <br>
                        <fieldset class="the-fieldset">
                            <legend class="the-legend"><label class="fyr">Gross CLSG Amount (KES)</label></legend>
                            <div class="form-group">
                                <label>Amount</label>
                                <vue-numeric separator="," class="form-control" required v-model="form.cslg_gross_amount" required disabled></vue-numeric>
                            </div>
                            <div class="form-group">
                                <label>Comment</label>
                                <textarea  class="form-control" v-model="form.cslg_gross_comment" required disabled></textarea>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-6">
                        <br>
                        <fieldset class="the-fieldset">
                            <legend class="the-legend"><label class="fyr">Performance Adjusted- CLSG Amount (KES)</label></legend>
                            <div class="form-group">
                                <label>Amount</label>
                                <vue-numeric separator="," class="form-control" required v-model="form.cslg_adjusted_amount" required disabled></vue-numeric>
                            </div>
                            <div class="form-group">
                                <label>Comment</label>
                                <textarea  class="form-control" v-model="form.cslg_adjusted_comment" required disabled></textarea>
                            </div>
                        </fieldset>
                    </div>

                </div>

                <div class="form-group text-center" style="margin-top: 1%">
                    <button type="button" class="btn btn-warning" @click="goBack()"><i class="fa fa-arrow-left" aria-hidden="true"> Back</i>
                    </button>
                </div>
            </form>
    </div>
</template>

<script>

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
            this.form = this.cslg;
        },
        goBack(){
            window.location.href = "/reports/cslg-calculation-list";
        }
    },

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
