export default {
    name: "RestoreUser",
    props: {
        user: {required: true, type: Object},
    },
    methods: {
        restoreUser() {
            this.$swal({
                title: 'Are you sure?',
                text: `Restore this user ${this.user.name}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    axios.post(`/users/${this.user.id}/restore`).then(response => {
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
