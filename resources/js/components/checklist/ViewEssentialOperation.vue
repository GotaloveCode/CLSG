<template>
    <div>
            <form>
            <div class="row">
                <h4 class="col-md-12 text-uppercase text-center">1. Essential Operations</h4>
                <div class="col-md-6" v-for="essn in essential_item.details" style="margin-top: -10px">
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
        essential_item: {type: Object},
        essentials: {type: Array}
    },
    methods:{
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
