<template>
    <div>
        <form>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-uppercase text-center">2.Vulnerable Customers</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6" v-for="cus in checklist.customer_details" style="margin-top: -10px">
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
                <div class="col-md-6" v-for="stf in checklist.staff_details" style="margin-top: -10px">
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
        customers: {type: Array},
        staff: {type: Array},
    },
   created(){
     console.log(this.checklist)
   },
    methods:{
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

        goBack(){
            window.location.href = "/reports/vulnerable-customer-list";
        }

    }
}
</script>
