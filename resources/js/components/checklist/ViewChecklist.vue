<template>
    <div>
<!--        TODO: Add linkage to below section A ViewCheckList-->
        <form>
            <div class="row">
                <h4 class="text-uppercase col-md-12 text-center">A. GENERAL </h4>
                <div class="col-md-4 form-group">
                    <label>Revenues collected this month (KES)</label>
                    <vue-numeric separator="," v-model="checklist.revenue" class="form-control" required disabled></vue-numeric>
                </div>
                <div class="col-md-4 form-group">
                    <label>O&M costs this month (KES)</label>
                    <vue-numeric separator="," v-model="checklist.operations_costs" class="form-control" required disabled></vue-numeric>
                </div>
                <div class="col-md-4 form-group">
                    <label>Total CLSG amount disbursed to date (KES)</label>
                    <vue-numeric separator="," v-model="checklist.clsg_total" class="form-control" required disabled></vue-numeric>
                </div>
                <div class="col-md-6 form-group">
                    <label>Challenges (if any) encountered during the reporting period and mitigation
                        measures</label>
                    <textarea class="form-control" v-model="checklist.challenges" disabled></textarea>
                </div>
                <div class="col-md-6 form-group">
                    <label>Expected activities for the next month (specifying any planned procurement or
                        contracting)</label>
                    <textarea class="form-control" required v-model="checklist.expected_activities" disabled></textarea>
                </div>
                <h4 class="col-md-12 text-uppercase text-center">1. Essential Operations</h4>
                <div class="col-md-6" v-for="essn in checklist.essential" style="margin-top: -10px">
                    <div class="card">
                        <div class="card-header">
                            <p><i class="fa fa-angle-double-right" aria-hidden="true"></i> {{getEssentialName(essn.id)}}</p>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body" style="padding-top: 0">
                            <span style="display: flex">
                              <div>
                              <fieldset class="radio disabled">
                                <label>
                                    <input type="radio"  value="Completed" v-model="essn.status" :name="'status_completed'+essn.id" disabled>
                                  <b>Completed</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio disabled">
                                <label>
                                    <input type="radio"  value="In Progress"  v-model="essn.status" :name="'status_in_progress'+essn.id" disabled>
                                    <b>In Progress</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio disabled">
                                <label>
                                    <input type="radio"  value="Not Started" v-model="essn.status" :name="'status_not_started'+essn.id" disabled>
                                   <b>Not Started</b>
                                </label>
                            </fieldset>
                              </div>
                                <div style="margin-left: 15%;">
                                   <textarea disabled="true"  cols="30" rows="2" class="form-control" v-model="essn.comment" placeholder="Your comment here"></textarea>
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
                    <h4 class="text-uppercase text-center">2.Vulnerable Customers</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" v-for="cus in checklist.customer" style="margin-top: -10px">
                    <div class="card">
                        <div class="card-header">
                            <p><i class="fa fa-angle-double-right" aria-hidden="true"></i> {{getCustomerName(cus.id)}}</p>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body" style="padding-top: 0">
                          <span style="display: flex">
                                <div>
                            <fieldset class="radio disabled">
                                <label>
                                    <input type="radio"  value="Completed" v-model="cus.status" :name="'status_completed_1'+cus.id" disabled>
                                    <b>Completed</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio disabled">
                                <label>
                                    <input type="radio"  value="In Progress" v-model="cus.status" :name="'status_in_progress_1'+cus.id" disabled>
                                    <b>In Progress</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio disabled">
                                <label>
                                    <input type="radio"  value="Not Started" v-model="cus.status" :name="'status_not_started_1'+cus.id" disabled>
                                    <b>Not Started</b>
                                </label>
                            </fieldset>
                                </div>
                                 <div style="margin-left: 15%;">
                                   <textarea disabled="true" cols="30" rows="2" class="form-control" v-model="cus.comment"  placeholder="Your comment here"></textarea>
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
                    <h4 class="text-uppercase text-center">3.Staff Health Protection</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" v-for="stf in checklist.staff" style="margin-top: -10px">
                    <div class="card">
                        <div class="card-header">
                            <p><i class="fa fa-angle-double-right" aria-hidden="true"></i> {{getStaffName(stf.id)}}</p>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body" style="padding-top: 0">
                            <span style="display: flex">
                                <div>
                            <fieldset class="radio disabled">
                                <label>
                                    <input type="radio"  value="Completed" v-model="stf.status" :name="'status_completed'+stf.id" disabled>
                                    <b>Completed</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio disabled">
                                <label>
                                    <input type="radio"  value="In Progress" v-model="stf.status" :name="'status_in_progress'+stf.id" disabled>
                                    <b>In Progress</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio disabled">
                                <label>
                                    <input type="radio"  value="Not Started" v-model="stf.status" :name="'status_not_started'+stf.id" disabled>
                                    <b>Not Started</b>
                                </label>
                            </fieldset>
                                </div>
                                  <div style="margin-left: 15%;">
                                   <textarea disabled="true" cols="30" rows="2" class="form-control" v-model="stf.comment" placeholder="Your comment here"></textarea>
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
                    <h4 class="text-uppercase text-center">4.Communication</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" v-for="comm in checklist.communication" style="margin-top: -10px">
                    <div class="card">
                        <div class="card-header">
                            <p><i class="fa fa-angle-double-right" aria-hidden="true"></i> {{getCommunicationName(comm.id)}}</p>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body" style="padding-top: 0">
                            <span style="display: flex">
                             <div>
                            <fieldset class="radio disabled">
                                <label>
                                    <input type="radio"  value="Completed" v-model="comm.status" :name="'status_completed'+comm.id" disabled>
                                    <b>Completed</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio disabled">
                                <label>
                                    <input type="radio"  value="In Progress" v-model="comm.status" :name="'status_in_progress'+comm.id" disabled>
                                    <b>In Progress</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio disabled">
                                <label>
                                    <input type="radio"  value="Not Started" v-model="comm.status" :name="'status_not_started'+comm.id" disabled>
                                    <b>Not Started</b>
                                </label>
                            </fieldset>
                             </div>
                                 <div style="margin-left: 15%;">
                                 <textarea disabled="true" cols="30" rows="2" class="form-control" v-model="comm.comment" placeholder="Your comment here"></textarea>
                               </div>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button type="button" class="btn btn-warning" @click="goBack()"><i class="fa fa-arrow-left" aria-hidden="true"> Back</i>
                </button>
            </div>
        </form>
    </div>
</template>


<script>
export default {
    props:{
      checklist: {type: Object},
        essentials: {type: Array},
        customers: {type: Array},
        staff: {type: Array},
        communication: {type: Array},
    },

    methods:{
        getEssentialName(id){
            if (this.essentials.length){
                return this.essentials.find(c => c.id ==id).name;
            }
        },
        getCustomerName(id){
            if (this.customers.length){
                return this.customers.find(c => c.id ==id).name;
            }
        },
        getStaffName(id){
            if (this.staff.length){
                return this.staff.find(c => c.id ==id).name;
            }
        },
        getCommunicationName(id){
            if (this.communication.length){
                return this.communication.find(c => c.id ==id).name;
            }
        },
        goBack(){
            window.location.href = "/reports/checklist-list";
        }

    }
}
</script>
