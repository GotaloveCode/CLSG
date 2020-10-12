<template>

</template>

<script>
export default {
    name: "ManageAttachments",
    props: {
        delete_url: {type: String}
    },
    methods: {
        deleteAttachment(item) {
            this.$swal({
                title: 'Are you sure?',
                text: 'Delete the attachment ' + item.display_name + '?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes Delete it!',
                cancelButtonText: 'No, Keep it!',
                showCloseButton: true,
                showLoaderOnConfirm: true
            }).then((result) => {
                if (result.value) {
                    let url = this.delete_url.replace('0', item.id);
                    axios.delete(url).then(() => {
                        location.reload();
                    }).catch((err) => {
                        this.$toastr.e(err.response.message, 'Error');
                    }).finally(() => {
                        this.sending = false
                    })
                }
            });
        }
    }
}
</script>

