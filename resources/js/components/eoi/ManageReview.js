import CommentForm from "./CommentForm";

export default {
    name: "ManageReview",
    components: {
        CommentForm
    },
    props: {
        submitUrl: {required: true, type: String},
    },
    data() {
        return {
            show_comment_dialog: false,
        }
    },
    methods: {
        review(action) {
            this.$swal({
                title: 'Are you sure?',
                text: "Change the status for the Expression of interest to " + action,
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
                        this.$toastr.e("An error occured");
                        console.log("err", error);
                    });
                }
            })

        }
    }
}
