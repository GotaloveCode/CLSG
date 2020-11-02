<template>
    <div>
        <div v-html="$error.handle(error)"/>
        <template v-if="show">
            <view-performance-card :score="score"></view-performance-card>
        </template>
        <div v-if="!show">
            <form @submit.prevent="postData()">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card" style="height: 92%">
                            <div class="card-header">
                                <p> 1. Maintain at least 50 percent collection efficiency</p>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body" style="padding-top: 0">
                            <div class="d-inline-block custom-control custom-radio mr-1">
                                <input type="radio" class="custom-control-input" name="collection_efficiency" id="yes_e" value="1" v-model="form.collection_efficiency">
                                <label class="custom-control-label" for="yes_e">Yes</label>
                            </div>
                            <div class="d-inline-block custom-control custom-radio mr-1">
                                <input type="radio" class="custom-control-input" name="collection_efficiency" id="no_e"  value="0" v-model="form.collection_efficiency">
                                <label class="custom-control-label" for="no_e">No</label>
                            </div>

                            <div class="form-group" v-if="form.collection_efficiency ==1" style="margin-top: 4%">
                                <label>Comment</label>
                                <textarea class="form-control" v-model="form.collection_efficiency_comment"></textarea>
                            </div>
                    </div>
                    </div>
                    </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card" style="height: 92%">
                            <div class="card-header">
                                <p> 2. Maintain NRW at pre-COVID levels</p>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body" style="padding-top: 0">
                              <div class="d-inline-block custom-control custom-radio mr-1">
                                <input type="radio" class="custom-control-input" name="nrw" id="yes_n" value="1" v-model="form.nrw">
                                <label class="custom-control-label" for="yes_n">Yes</label>
                            </div>
                            <div class="d-inline-block custom-control custom-radio mr-1">
                                <input type="radio" class="custom-control-input" name="nrw" id="no_n"  value="0" v-model="form.nrw">
                                <label class="custom-control-label" for="no_n">No</label>
                            </div>

                            <div class="form-group" v-if="form.nrw ==0" style="margin-top: 4%">
                                <label>Maintain NRW at pre-COVID levels Comment</label>
                                <textarea class="form-control" v-model="form.nrw_comment"></textarea>
                            </div>
                    </div>
                    </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card" style="height: 92%">
                            <div class="card-header">
                                <p> 3. Maintain at least 8 hours of service per day in urban areas</p>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body" style="padding-top: 0">
                            <div class="d-inline-block custom-control custom-radio mr-1">
                                <input type="radio" class="custom-control-input" name="service_per_day" id="yes_c" value="1" v-model="form.service_per_day">
                                <label class="custom-control-label" for="yes_c">Yes</label>
                            </div>
                            <div class="d-inline-block custom-control custom-radio mr-1">
                                <input type="radio" class="custom-control-input" name="service_per_day" id="no_c"  value="0" v-model="form.service_per_day">
                                <label class="custom-control-label" for="no_c">No</label>
                            </div>

                            <div class="form-group" v-if="form.service_per_day ==1" style="margin-top: 4%">
                                <label>Comment</label>
                                <textarea class="form-control" v-model="form.service_per_day_comment"></textarea>
                            </div>
                                </div>
                            </div>
                    </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card" style="height: 92%">
                            <div class="card-header">
                                <p> 4. Maintain drinking water quality within acceptable range</p>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body" style="padding-top: 0">
                            <div class="d-inline-block custom-control custom-radio mr-1">
                                <input type="radio" class="custom-control-input" name="drinking_water" id="yes_d" value="1" v-model="form.drinking_water">
                                <label class="custom-control-label" for="yes_d">Yes</label>
                            </div>
                            <div class="d-inline-block custom-control custom-radio mr-1">
                                <input type="radio" class="custom-control-input" name="drinking_water" id="no_d"  value="0" v-model="form.drinking_water">
                                <label class="custom-control-label" for="no_d">No</label>
                            </div>

                            <div class="form-group" v-if="form.drinking_water ==1" style="margin-top: 4%">
                                <label>Comment</label>
                                <textarea class="form-control" v-model="form.drinking_water_comment"></textarea>
                            </div>
                                </div>
                            </div>
                    </div>
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
import ViewPerformanceCard from "./ViewPerformanceCard";

export default {
    props:{
        score:{type: [Object,Array]}
    },
    data() {
        return {
            error: '',
            form: {
                collection_efficiency:0,
                collection_efficiency_comment:'',
                nrw:0,
                nrw_comment:'',
                service_per_day:0,
                service_per_day_score:0,
                service_per_day_comment:'',
                drinking_water:0,
                drinking_water_comment:'',
                bcp_score:10,
                erp_score:10,
                bcp_erp_score:10,
                financial_score:15,
                performance_score:0,
                compliance_score:15,
                collection_efficiency_score:0,
                nrw_score:0,
                drinking_water_score:0
            },
            loading: false,
            show: false
        }
    },
    created() {
     this.setUp();
    },
    methods: {
        setUp(){
            console.log(this.score)
            if (this.score.id !=undefined){
                this.show = true;
            }
        },
        postData() {
            this.computeScores();
            this.error = '';
            this.loading = true;
            console.log(this.form)
            axios.post("/reports/performance-score-card", this.form).then(() => {
                window.location.href = "/reports/performance-score-card-list"
            }).catch(error => {
                this.error = error.response;
            });

        },
        computeScores(){
            if (this.form.service_per_day ==1) this.form.service_per_day_score = 10;
            else this.form.service_per_day_score = 0;

            if (this.form.nrw ==1) this.form.nrw_score = 10;
            else this.form.nrw_score = 0;

            if (this.form.drinking_water ==1) this.form.drinking_water_score = 10;
            else this.form.drinking_water_score = 0;

            if (this.form.collection_efficiency ==1) this.form.collection_efficiency_score = 10;
            else this.form.collection_efficiency_score = 0;
        }
    },
    components: {
        ViewPerformanceCard
    }
}
</script>
