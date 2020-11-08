<template>
    <div>
        <div v-html="$error.handle(error)"/>
        <form @submit.prevent="onSubmit()">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Month: </label>
                                <template v-if="essential_item.length">
                                    <input class="form-control" disabled v-model="essential_item.month">
                                </template>
                                <v-select v-else label="name" placeholder="Select Month"
                                          v-model="form.month" :reduce="c => c.no" :options="mths">
                                </v-select>
                            </div>
                            <div class="col-md-4 form-group">
                                <label>Year</label>
                                <input class="form-control" disabled v-model="form.year">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" v-for="(essn,k) in essentials" style="margin-top: -10px">
                    <div class="card" style="height: 92%">
                        <div class="card-header">
                            <p> {{ k + 1 }}. {{ essn.name }}</p>
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
                                   <textarea required cols="30" rows="2" class="form-control"
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
</template>


<script>
import moment from "moment";
import months from "../months";

export default {
    props: {
        items: {type: Array},
        essential_item: {type: [Object, Array]}
    },
    data() {
        return {
            error: '',
            mths: [],
            form: {
                month: moment().month(),
                year: moment().year(),
                essential: [],
                essential_comment: []
            },
            essential_data: [],
            loading: false,
            essentials: {}
        }
    },
    created() {
        this.setUp();
    },
    methods: {
        setUp() {
            let allowed = [moment().month()];
            if (moment().date() <= 5) {
                allowed.push(moment().month() - 1);
                this.form.month = moment().month() - 1;
            }
            this.mths = months.filter(x => allowed.includes(x.no));
            this.essentials = this.items.filter(e => e.type === "Essential Operations");
            if (this.essential_item.length) {
                this.form.year = this.essential_item.year;
                for (let i = 0; i < this.essential_item.details.length; i++) {
                    this.form.essential[i+1] = this.essential_item.details[i].status;
                    this.form.essential_comment[i+1] = this.essential_item.details[i].comment;
                }
            }
        },
        onSubmit() {
            let ess = this.validateEssentials();
            if (ess == "comment_required") return this.$toastr.e("Comments are required for In Progress/Not Started Essential Operations!");
            if (!ess) return this.$toastr.e("All Essential Operations Checklist fields are required!");
            this.error = '';
            this.loading = true;
            this.essential_item.length ? this.updateData() : this.postData();
        },
        postData() {
            axios.post("/essential-operation", {
                details: this.essential_data,
                month: this.form.month,
                year: this.form.year
            }).then(() => {
                window.location.href = "/essential-operation"
            }).catch(error => {
                this.error = error.response;
            });
        },
        updateData() {
            axios.put("/essential-operation/" + this.essential_item.id, {
                details: this.essential_data
            }).then(() => {
                window.location.href = "/essential-operation"
            }).catch(error => {
                this.error = error.response;
            });
        },
        validateEssentials() {
            this.essential_data = [];
            let status = true;
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
            this.essential_data.forEach(e => {
                if (e.status != "Completed" && e.comment === "") {
                    status = false;
                    return;
                }
            })
            if (!status) return "comment_required";
            return true;
        },
    }
}
</script>
