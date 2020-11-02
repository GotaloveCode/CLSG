<template>
    <div>
        <div class="row">
        <div class="col-md-6 col-sm-12"  v-for="essn in essential_item.details">
            <div class="card" style="height: 98%">
                <div class="card-header">
                    <div class="heading-elements">
                        <span :class="['badge round',getAppliedClass(essn.status)]" style="font-weight: 800">{{ essn.status }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <h4 class="card-title">Description</h4>
                    <p class="card-text">{{getEssentialName(essn.id)}}</p>

                    <h4 class="card-title" v-if="essn.comment">Notes:</h4>
                    <p>{{essn.comment}}</p>
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
    data(){
      return {
          applied_class:true
      }
    },

    props:{
        essential_item: {type: Object},
        essentials: {type: Array}
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
        getEssentialName(id){
            if (this.essentials.length){
                return this.essentials.find(c => c.id ==id).name;
            }
        },

        goBack(){
            window.location.href = "/reports/essential-operation-list";
        }

    }
}
</script>
