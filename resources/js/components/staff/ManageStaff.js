import StaffForm from "./Create";
import Modal from "../Modal";
export default {
    name: "ManageStaff",
    components: {
        StaffForm,
        Modal
    },
    props:{
        staff: { required:true, type: Object}
    },
    data() {
        return {
            show_edit_dialog:false,
            show_delete_dialog: false,
            error: '',
        }
    },
    methods: {
        deleteStaff() {
            this.$swal({
                title: 'Are you sure?',
                text: "Delete the staff " + this.staff.firstname,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    axios.delete(`/staff/${this.staff.id}`).then(response => {
                        this.$toastr.s(response.data.message, "Success");
                        location.href = '/staff';
                    }).catch(error => {
                        this.error = error.response;
                    });
                }
            })

        }
    }
}
