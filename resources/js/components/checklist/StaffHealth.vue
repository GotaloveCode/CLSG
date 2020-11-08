<template>
    <div>
        <div v-html="$error.handle(error)"/>
        <form @submit.prevent="onSubmit()">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Month</label>
                                <v-select label="name" placeholder="Select Month"
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
                <div class="col-md-6" v-for="stf in staff" style="margin-top: -10px">
                    <div class="card">
                        <div class="card-header">
                            <p><i class="fa fa-angle-double-right" aria-hidden="true"></i> {{ stf.name }}</p>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body" style="padding-top: 0">
                            <span style="display: flex">
                                <div>
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" value="Completed" v-model="form.staff[stf.id]"
                                           :name="'status_completed'+stf.id">
                                    <b>Completed</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" value="In Progress" v-model="form.staff[stf.id]"
                                           :name="'status_in_progress'+stf.id">
                                    <b>In Progress</b>
                                </label>
                            </fieldset>
                            <fieldset class="radio">
                                <label>
                                    <input type="radio" value="Not Started" v-model="form.staff[stf.id]"
                                           :name="'status_not_started'+stf.id">
                                    <b>Not Started</b>
                                </label>
                            </fieldset>
                                </div>
                                  <div style="margin-left: 15%;">
                                   <textarea cols="30" rows="2" class="form-control" required
                                             v-model="form.staff_comment[stf.id]"
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
        checklists: {type: Array},
        checklist_item: {type: [Object, Array]}
    },
    data() {
        return {
            mths: [],
            error: '',
            form: {
                month: moment().month(),
                year: moment().year(),
                staff: [],
                staff_comment: []
            },
            staff_data: [],
            loading: false,
            staff: {}
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
            this.staff = this.checklists.filter(e => e.type === "Staff Health Protection");
            if (this.checklist_item.id != undefined) {
                this.form.year = this.checklist_item.year;
                for (let i = 0; i < this.checklist_item.staff_details.length; i++) {
                    this.form.staff[this.checklist_item.staff_details[i].id] = this.checklist_item.staff_details[i].status;
                    this.form.staff_comment[this.checklist_item.staff_details[i].id] = this.checklist_item.staff_details[i].comment;
                }
            }
        },
        onSubmit() {
            let staff = this.validateStaff();
            if (staff == "comment_required") return this.$toastr.e("Comments are required for In Progress/Not Started Staff Health Protection Checklist are required!");
            if (!staff) return this.$toastr.e("All Staff Health Protection Checklist fields are required!");
            this.error = '';
            this.loading = true;
            if (this.checklist_item.id != undefined) this.updateData(); else this.postData();
        },
        postData() {
            axios.post("/staff-health", {
                month: this.form.month,
                year: this.form.year,
                staff_details: this.staff_data
            }).then(() => {
                window.location.href = "/staff-health"
            }).catch(error => {
                this.loading = false;
                this.error = error.response;
            });
        },
        updateData() {
            axios.put("/staff-health/" + this.checklist_item.id, {staff_details: this.staff_data}).then(() => {
                this.$toastr.s("Staff Health Protection report updated successfully!");
                location.href = "/staff-health"
            }).catch(error => {
                this.loading = false;
                this.error = error.response;
            });
        },
        validateStaff() {
            this.staff_data = [];
            let status = true;

            this.form.staff.forEach((e, v) => {
                this.staff_data.push({id: v, status: e, comment: ""})
            })
            if (this.staff_data.length < 11) {
                return false;
            }

            this.form.staff_comment.forEach((p, q) => {
                for (let i = 0; i < this.staff_data.length; i++) {
                    if (this.staff_data[i]['id'] === q) {
                        this.staff_data[i]['comment'] = p;
                    }
                }
            })

            this.staff_data.forEach(e => {
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
