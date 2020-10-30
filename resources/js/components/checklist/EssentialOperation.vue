<template>
    <div>
        <div v-html="$error.handle(error)"/>
        <template v-if="show">
            <view-essential-operation :essential_item="essential_item" :essentials="items"></view-essential-operation>
        </template>
        <div v-if="!show">
            <form @submit.prevent="postData()">
                <div class="row">
                    <h4 class="text-uppercase col-md-12 text-center">1. Essential Operations </h4>
                    <div class="col-md-6" v-for="essn in essentials" style="margin-top: -10px">
                        <div class="card">
                            <div class="card-header">
                                <p><i class="fa fa-angle-double-right" aria-hidden="true"></i> {{ essn.name }}</p>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body" style="padding-top: 0">
                            <span style="display: flex">
                              <div>
                              <fieldset class="radio">
                                <label>
                                    <input type="radio" value="Completed" v-model="form.essential[essn.id]"
                                           :name="'status_completed'+essn.id">
                                  <b>Completed</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" value="In Progress" v-model="form.essential[essn.id]"
                                           :name="'status_in_progress'+essn.id">
                                    <b>In Progress</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" value="Not Started" v-model="form.essential[essn.id]"
                                           :name="'status_not_started'+essn.id">
                                   <b>Not Started</b>
                                </label>
                            </fieldset>
                              </div>
                                <div style="margin-left: 15%;">
                                   <textarea cols="30" rows="2" class="form-control"
                                             v-model="form.essential_comment[essn.id]"
                                             placeholder="Your comment here"></textarea>
                                </div>

                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center">
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
import ViewEssentialOperation from "./ViewEssentialOperation";

export default {
    props:{
        items:{type:Array},
        essential_item:{type: [Object, Array]}
    },
    data() {
        return {
            error: '',
            form: {
                essential: [],
                essential_comment: []
            },
            essential_data: [],
            loading: false,
            show: false,
            essentials:{}
        }
    },
    created() {
        this.setUp();
    },
    methods: {
        setUp(){
            this.essentials = this.items.filter(e => e.type ==="Essential Operations");
            if (this.essential_item.id !=undefined){
                this.show = true;
            }
        },
        postData() {
            if (!this.validateEssentials()) return this.$toastr.e("All Essential Operations Checklist fields are required!");
            let data = {
                details: this.essential_data
            };
            this.error = '';
            this.loading = true;
            axios.post("/reports/essential-operation", data).then(() => {
                window.location.href = "/reports/essential-operation-list"
            }).catch(error => {
                this.error = error.response;
            });

        },
         validateEssentials() {
            this.essential_data = [];
            if (this.form.essential.length < 7) {
                return false;
            }
            this.form.essential.forEach((e, v) => {
                this.essential_data.push({id: v, status: e, comment: ""})
            })
            this.form.essential_comment.forEach((p, q) => {
                for (let i = 0; i < this.essential_data.length; i++) {
                    if (this.essential_data[i]['id'] === q) {
                        this.essential_data[i]['comment'] = p;
                    }
                }
            })
            return true;
        },
    },
    components: {
        ViewEssentialOperation
    }
}
</script>
