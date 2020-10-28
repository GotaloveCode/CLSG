<template>
    <div>
        <div>
            <div>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-uppercase text-center">A. Summary </h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="margin-left: 10px">Wsp</label>
                               <input type="text" class="form-control" v-model="verification.wsp" required
                                   style="margin-left: 10px;width: 94%">
                        </div>
                        <div class="form-group">
                            <label style="margin-left: 10px">Recommendations</label>
                            <textarea cols="20" rows="2" v-model="verification.recommendations" class="form-control"  style="margin-left: 10px;width: 94%"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Verification team</label>
                            <textarea cols="20" rows="2" v-model="verification.verification_team" class="form-control"  style="width: 94%"></textarea>
                        </div>

                    </div>

                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-uppercase text-center">B.Performance Score</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" v-for="score in verification.performance_score_details" style="margin-top: -10px">
                    <div class="card">
                        <div class="card-header">
                            <p><i class="fa fa-angle-double-right" aria-hidden="true"></i><b>Indicator:</b>
                                {{ getScoreName(score.id) }}</p>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body" style="padding-top: 0">
                          <span style="display: flex">
                                <div>
                                    <h6>Performance score</h6>
                            <div class="form-group">

                                <span style="display: flex">
                                   <div>
                                     <input type="number" class="form-control" v-model="score.score_value">
                                   </div>
                                   <div>
                                     <p>out of</p>
                                   </div>
                                   <div>
                                     <input type="number" class="form-control" v-model="score.score_out">
                                   </div>
                                </span>
                            </div>
                                </div>
                                 <div style="margin-left: 4%;">
                                   <div class="form-group" style="margin-top: 10px">
                                       <textarea cols="30" rows="2" class="form-control" v-model="score.comment"
                                                 placeholder="Your comment here"></textarea>
                                   </div>
                                </div>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-uppercase text-center">C. Determination of CLSG Amount</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" v-for="dt in verification.clsg_details" style="margin-top: -10px">
                    <div class="card">
                        <div class="card-header">
                            <p><i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                {{ getDeterminationName(dt.id) }}</p>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body" style="padding-top: 0">
                            <span style="display: flex">
                                <div>
                            <div class="form-group" style="margin-top: 7%">
                                <input type="number" class="form-control" step="0.001" v-model="dt.amount"
                                       placeholder="Amount">
                            </div>
                                </div>
                                  <div style="margin-left: 5%;">
                                   <textarea cols="30" rows="2" class="form-control" v-model="dt.comment"
                                             placeholder="Your comment here"></textarea>
                                </div>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button type="button" class="btn btn-warning" @click="goBack()"><i class="feather icon-arrow-left"
                                                                                   aria-hidden="true"> Back</i>
                </button>
            </div>

        </div>
    </div>
</template>


<script>
import {mapGetters} from "vuex";

export default {
    computed: {
        ...mapGetters({
            scores: "getScores",
            determinations: "getDeterminations",
            verification: "getVerification"
        })
    },
    methods: {
        getScoreName(id) {
            if (this.scores.length) {
                return this.scores.find(c => c.id == id).name;
            }
        },
        getDeterminationName(id) {
            if (this.determinations.length) {
                return this.determinations.find(c => c.id == id).name;
            }
        },

        goBack() {
            window.location.href = "/reports/monthly-verification";
        }
    }
}
</script>
