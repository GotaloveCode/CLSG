import CommentForm from "./CommentForm";
import MgmForm from "./bcp/MgmForm";

export default {
    name: "ManageReview",
    components: {
        CommentForm,
        MgmForm
    },
    props: {
        submitUrl: {required: true, type: String},
    },
    data() {
        return {
            error:"",
            show_comment_dialog: false,
        }
    },
    methods: {
        review(action) {
            this.$swal({
                title: 'Are you sure?',
                text: "Change the status to " + action,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.value) {
                    axios.post(this.submitUrl, {
                        status: action,
                    }).then(response => {
                        this.$toastr.s(response.data.message, "Success");
                        location.href = response.data.route;
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
            })

        }
    }
}
