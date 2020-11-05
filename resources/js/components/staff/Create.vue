<template>
    <ValidationObserver v-slot="{ handleSubmit }">
        <div v-html="$error.handle(error)"/>
        <form @submit.prevent="handleSubmit(onSubmit)" class="form">
            <div class="form-body row">
                <ValidationProvider name="FirstName" rules="required" v-slot="{ errors }"
                                    class="col-md-4 form-group">
                    <label>Firstname</label>
                    <input
                        v-model="user.firstname"
                        autocomplete="firstname"
                        type="text"
                        class="form-control"
                    >
                    <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                </ValidationProvider>
                <ValidationProvider name="Lastname" rules="required" v-slot="{ errors }"
                                    class="col-md-4 form-group">
                    <label>Lastname</label>
                    <input
                        v-model="user.lastname"
                        autocomplete="lastname"
                        type="text"
                        class="form-control"
                    >
                    <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                </ValidationProvider>
                <ValidationProvider name="Email" rules="required|email" v-slot="{ errors }"
                                    class="col-md-4 form-group">
                    <label>Email</label>
                    <input
                        v-model="user.email"
                        autocomplete="email"
                        type="text"
                        class="form-control"
                    >
                    <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                </ValidationProvider>
                <ValidationProvider name="Phone" rules="required" v-slot="{ errors }"
                                    class="col-md-4 form-group">
                    <label>Phone</label>
                    <input
                        v-model="user.phone"
                        autocomplete="tel"
                        type="text"
                        class="form-control"
                    >
                    <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                </ValidationProvider>
                <ValidationProvider name="Position" rules="required" v-slot="{ errors }"
                                    class="col-md-4 form-group">
                    <label>Position </label>
                    <input
                        v-model="user.position"
                        class="form-control"
                    />
                    <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                </ValidationProvider>
                <ValidationProvider name="Type" rules="required" v-slot="{ errors }"
                                    class="col-md-4 form-group">
                    <label>Type</label>
                    <v-select
                        :options="types"
                        v-model="user.type"
                        placeholder="eg. Essential or Backup"
                    ></v-select>
                    <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                </ValidationProvider>
                <ValidationProvider name="Skills" rules="required" v-slot="{ errors }"
                                    class="col-md-6 form-group">
                    <label>Skills </label>
                    <textarea
                        v-model="user.skills"
                        type="text"
                        class="form-control"
                    ></textarea>
                    <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                </ValidationProvider>
                <ValidationProvider name="Qualifications" rules="required" v-slot="{ errors }"
                                    class="col-md-6 form-group">
                    <label>Qualifications</label>
                    <textarea
                        v-model="user.qualifications"
                        class="form-control"
                    ></textarea>
                    <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                </ValidationProvider>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-check-square-o"></i> Save
                </button>
            </div>
        </form>
    </ValidationObserver>
</template>

<script>
export default {
    name: 'StaffForm',
    props: {
        wspid: {required: true, type: String},
        existingStaff: {type: Object},
    },
    data() {
        return {
            user: {
                firstname: '',
                middlename: '',
                email:'',
                phone:'',
                lastname: '',
                qualifications: '',
                skills: '',
                position: '',
                wsp_id: null
            },
            types: ['Essential', 'Backup'],
            error: '',
        }
    },
    mounted() {
        this.setWspId();
    },
    methods: {
        onSubmit() {
            this.error = '';
            if (this.existingStaff) this.updateData(this.existingStaff.id);
            else this.postData();
        },
        initStaff() {
            this.user = this.existingStaff;
        },
        postData() {
            axios.post('/staff', this.user).then((response) => {
                this.$toastr.s(response.data.message);
                location.href = "/staff";
            }).catch(error => {
                this.error = error.response;
            });
        },
        updateData(id) {
            axios.put(`/staff/${id}`, this.user).then(() => {
                this.$toastr.s("Staff updated successfully!");
                location.reload();
            }).catch(error => {
                this.error = error.response;
            });
        },
        setWspId() {
            this.user.wsp_id = this.wspid;
            if (this.existingStaff) {
                this.initStaff();
            }
        }
    },
}
</script>
