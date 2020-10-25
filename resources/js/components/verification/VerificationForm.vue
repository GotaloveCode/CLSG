<template>
    <div class="row">
        <div class="col-md-12">
            <div v-html="$error.handle(error)"/>
            <template v-if="show_date_form && !show">
                <date-form></date-form>
            </template>
            <template v-if="show && !show_date_form">
                <view-verification></view-verification>
            </template>
            <div v-if="!show && !show_date_form">
                <form @submit.prevent="postData()" class="form">
                    <h4 class="text-uppercase text-center">A. Summary </h4>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Wsp</label>
                            <v-select type="text" label="name" :reduce="c=>c.id" v-model="form.wsp_id" :options="wsps"
                                      required></v-select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Verification team</label>
                            <textarea class="form-control" v-model="form.verification_team" required></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Recommendations</label>
                            <textarea class="form-control" v-model="form.recommendations"
                                      placeholder="recommendations"></textarea>
                        </div>
                        <hr>
                        <h4 class="text-uppercase col-md-12 text-center">B.Performance Score</h4>
                        <div class="col-md-6" v-for="score in scores" style="margin-top: -10px">
                            <div class="card">
                                <div class="card-header">
                                    <p><i class="fa fa-angle-double-right" aria-hidden="true"></i><b>Indicator:</b>
                                        {{ score.name }}</p>
                                </div>
                                <div class="card-content ">
                                    <div class="card-body" style="padding-top: 0">
                                        <div style="display: flex">
                                            <div>
                                                <h6>Performance score</h6>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col">
                                                            <input type="number" class="form-control"
                                                                   v-model="form.score_value[score.id]">
                                                        </div>
                                                        <div class="col-md-auto">
                                                            out of
                                                        </div>
                                                        <div class="col">
                                                            <input type="number" class="form-control"
                                                                   v-model="form.score_out_of[score.id]">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="margin-left: 4%;">
                                                <div class="form-group" style="margin-top: 10px">
                                       <textarea cols="30" rows="2" class="form-control"
                                                 v-model="form.score_comment[score.id]"
                                                 placeholder="Your comment here"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4 class="text-uppercase col-md-12 text-center">C. Determination of CLSG Amount</h4>
                        <div class="col-md-6" v-for="dt in determinations" style="margin-top: -10px">
                            <div class="card">
                                <div class="card-header">
                                    <p><i class="fa fa-angle-double-right" aria-hidden="true"></i> {{ dt.name }}</p>
                                </div>
                                <div class="card-content">
                                    <div class="card-body pt-0">
                                        <div style="display: flex">
                                            <div>
                                                <div class="form-group" style="margin-top: 7%">
                                                    <input type="number" class="form-control" step="0.001"
                                                           v-model="form.amount[dt.id]"
                                                           placeholder="Amount">
                                                </div>
                                            </div>
                                            <div style="margin-left: 5%;">
                                   <textarea cols="30" rows="2" class="form-control"
                                             v-model="form.determination_comment[dt.id]"
                                             placeholder="Your comment here"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button class="btn btn-warning" v-if="loading" type="button">Sending ... <i
                            class="feather icon-loader"></i></button>
                        <button type="submit" class="btn btn-primary">
                            Submit <i class="feather icon-send"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>


<script>
import ViewVerification from "./ViewVerification";
import DateForm from "./DateForm";
import {mapGetters} from "vuex";

export default {
    props: {
        wsps: {required: true, type: Array}
    },
    data() {
        return {
            error:'',
            form: {
                wsp_id: null,
                verification_period: '',
                verification_team: '',
                recommendations: '',
                amount: [],
                score_value: [],
                score_out_of: [],
                score: [],
                score_comment: [],
                determination_comment: []
            },
            scores_data: [],
            determination_data: [],
            show: false,
            show_date_form: true,
            loading: false,
        }
    },
    created() {
        this.listen();
    },
    computed: {
        ...mapGetters({
            scores: "getScores",
            determinations: "getDeterminations",
            month: "getMonths",
            year: "getYears"
        })
    },
    methods: {
        postData() {
            let deter = this.validateDeterminations();
            if (deter === "negative_value") return this.$toastr.e("Negative values are not allowed!");
            if (!deter) return this.$toastr.e("All Determination of CSLG Amount fields are required!");

            let scores = this.validateScores();
            if (scores === 'negative_value') return this.$toastr.e("Negative values are not allowed!");
            if (scores === "greater_value") return this.$toastr.e("Score cannot be greater than total score!");
            if (!scores) return this.$toastr.e("All Performance Score fields are required!");
            this.error = '';
            let data = {
                performance_score_details: this.scores_data,
                clsg_details: this.determination_data,
                wsp_id: this.form.wsp_id,
                recommendations: this.form.recommendations,
                verification_period: this.form.verification_period,
                verification_team: this.form.verification_team,
                month: this.month,
                year: this.year
            };
            this.loading = true;
            axios.post("/reports/verification", data).then(() => {
                this.show_date_form = true;
                this.show = false;
                this.loading = false;
            }).catch(error => {
                this.error = error.response;
            });

        },
        validateScores() {
            this.scores_data = [];
            let result = "";
            this.form.score_value.forEach((e, v) => {
                this.scores_data.push({id: v, score_value: e, score_out: "", comment: ""})
                if (e < 0) {
                    result = "negative_value";
                    return;
                }
            })
            if (result) return "negative_value";
            if (this.scores_data.length < 9) return false;

            this.form.score_out_of.forEach((e, v) => {
                for (let i = 0; i < this.scores_data.length; i++) {
                    if (this.scores_data[i]['id'] === v) {
                        this.scores_data[i]['score_out'] = e;

                        if (parseInt(e) < 0) {
                            result = "negative_value";
                            return;
                        } else if (parseInt(e) < parseInt(this.scores_data[i]['score_value'])) {
                            result = "greater_value";
                            return;
                        }
                    }

                }
            })
            if (result === "negative_value") return "negative_value";
            else if (result === "greater_value") return "greater_value";

            this.scores_data.forEach(value => {
                if (value.score_out === "" || value.score_value === "") {
                    result = false;
                    return;
                }
            })
            if (result === false) return false;
            this.form.score_comment.forEach((e, v) => {
                for (let i = 0; i < this.scores_data.length; i++) {
                    if (this.scores_data[i]['id'] === v) {
                        this.scores_data[i]['comment'] = e;
                    }
                }
            })

            return true;
        },
        validateDeterminations() {
            this.determination_data = [];
            let result = "";
            this.form.amount.forEach((e, v) => {
                this.determination_data.push({id: v, amount: e, comment: ""})
                if (e < 0) {
                    result = "negative_value";
                    return "negative_value";
                } else if (e === "") {
                    result = false;
                    return false;
                }
            })

            if (result === "negative_value") return "negative_value";
            if (result === false) return false;
            if (this.determination_data.length < 4) return false;

            this.form.determination_comment.forEach((m, n) => {
                for (let i = 0; i < this.determination_data.length; i++) {
                    if (this.determination_data[i]['id'] === n) {
                        this.determination_data[i]['comment'] = m;
                    }
                }
            })
            console.log(this.determination_data)
            return true;
        },

        listen() {
            eventBus.$on("verification_form", () => {
                this.show_date_form = false;
                this.show = false;
            })
            eventBus.$on("view_verification", () => {
                this.show_date_form = false;
                this.show = true;
            })
        }
    },
    components: {
        ViewVerification,
        DateForm
    }
}
</script>
