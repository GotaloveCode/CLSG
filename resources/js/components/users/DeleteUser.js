export default {
    name: "DeleteUser",
    props: {
        user: {required: true, type: Object},
    },
    methods: {
        deleteUser() {
            this.$swal({
                title: 'Are you sure?',
                text: `Delete this user ${this.user.name}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    axios.delete(`/users/${this.user.id}`).then(response => {
                        this.$toastr.s(response.data.message, "Success");
                        location.href = "/users";
                    }).catch(error => {
                        if (error.response.status === 422) {
                            let str = '';
                            Object.values(error.response.data.errors).forEach(e => {
                                str += '<p>' + e + '</p>';
                            });
                            this.$toastr.e(str);
                        } else {
                            this.$toastr.e("An error occured");
                        }
                    });
                }
            })
        }
    }
}
