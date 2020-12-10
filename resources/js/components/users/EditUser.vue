<template>
    <ValidationObserver v-slot="{ handleSubmit }">
        <div v-html="$error.handle(error)"/>
        <form class="form" @submit.prevent="handleSubmit(onSubmit)">
            <div class="form-group row">
                <ValidationProvider name="Name" rules="required" v-slot="{ errors }"
                                    class="col-md-4 form-group">
                    <label>Name</label>
                    <input type="text" name="name" v-model="edit_user.name" placeholder="Full Name"
                           class="form-control">
                    <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                </ValidationProvider>
                <ValidationProvider name="Email" rules="required" v-slot="{ errors }"
                                    class="col-md-4 form-group">
                    <label>Email</label>
                    <input type="email" name="email" v-model="edit_user.email" placeholder="Email"
                           class="form-control">
                    <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                </ValidationProvider>

                <ValidationProvider name="Roles" rules="required" v-slot="{ errors }"
                                    class="col-md-4 form-group">
                    <label>Role</label>
                    <v-select name="roles" multiple label="name" v-model="edit_user.role" :reduce="c => c.id"
                              :options="roles">
                    </v-select>
                    <span class="ml-2 text-danger"> {{ errors[0] }}</span>
                </ValidationProvider>
<!--                <ValidationProvider name="Organization" rules="required" v-slot="{ errors }"-->
<!--                                    class="col-md-4 form-group">-->
<!--                    <label>Organization</label>-->
<!--                    <v-select name="organization" label="name" v-model="edit_user.role" :reduce="c => c.id"-->
<!--                              :options="roles">-->
<!--                    </v-select>-->
<!--                    <span class="ml-2 text-danger"> {{ errors[0] }}</span>-->
<!--                </ValidationProvider>-->
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-check-square-o"></i> Submit
                </button>
            </div>
        </form>
    </ValidationObserver>
</template>

<script>
export default {
    name: "EditUser",
    props: {
        user: {required: true, type: Object},
        roles: {required: true, type: Array},
    },
    data: () => ({
        error: '',
        edit_user: {
            id: null,
            email: '',
            name: '',
            role: null,
            // organization: null
        }
    }),
    methods: {
        onSubmit() {
            this.error = '';
            axios.put(`/users/${this.edit_user.id}`, this.edit_user).then(response => {
                this.$toastr.s("User updated successfully!");
                location.href = "/users";
            }).catch(error => {
                this.error = error.response;
            });
        },
    },
    mounted() {
        this.edit_user = this.user;
        this.edit_user.role = this.user.roles;
    }
}
</script>

