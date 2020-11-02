<template>
    <div>
        <div class="row">
            <div class="col-md-6 col-sm-12"  v-for="staff in checklist.staff_details">
                <div class="card" style="height: 98%">
                    <div class="card-header">
                        <div class="heading-elements">
                            <span :class="['badge round',getAppliedClass(staff.status)]" style="font-weight: 800">{{ staff.status }}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Description</h4>
                        <p class="card-text">{{getStaffName(staff.id)}}</p>

                        <h4 class="card-title" v-if="staff.comment">Notes:</h4>
                        <p>{{staff.comment}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-center" style="margin-top: 1%">
            <button type="button" class="btn btn-warning" @click="goBack()"><i class="fa fa-arrow-left" aria-hidden="true"> Back</i>
            </button>
        </div>
    </div>
</template>


<script>
export default {
    props:{
        checklist: {type: Object},
        staff: {type: Array},
    },
    created(){
        console.log(this.checklist)
    },
    methods:{
        getAppliedClass(status){
            let badge='';
            switch (status){
                case 'Completed':
                    badge = "badge-success";
                    break
                case 'Not Started':
                    badge="badge-warning";
                    break;
                case 'In Progress':
                    badge="badge-info";
                    break;
                default:
                    badge="badge-success";
                    break;
            }
            return badge;
        },
        getStaffName(id){
            if (this.staff.length){
                return this.staff.find(c => c.id ==id).name;
            }
        },

        goBack(){
            window.location.href = "/reports/staff-health-list";
        }

    }
}
</script>
