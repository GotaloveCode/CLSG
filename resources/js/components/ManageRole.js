export default {
    name: "ManageRole",
    props: {
        role: {required: true, type: Object},
    },
    methods: {
        deleteRole() {
            this.$swal({
                title: 'Are you sure?',
                text: `Delete this role ${this.role.name}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    axios.delete(`/roles/${this.role.id}`).then(response => {
                        this.$toastr.s(response.data.message, "Success");
                        location.href = "/roles";
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
        },
        updateRole() {
            axios.post(this.submitUrl, this.role).then(response => {
                this.$toastr.s(response.data.message, "Success");
                location.href = "/roles";
            }).catch(error => {
                console.log(error);
                if(error.response.status === 422){
                    let str = '';
                    Object.values(error.response.data.errors).forEach(e => {
                        str += '<p>' + e + '</p>';
                    });
                    this.$toastr.e(str);
                }else{
                    this.$toastr.e("An error occured");
                }
            });
        }
    }
}
