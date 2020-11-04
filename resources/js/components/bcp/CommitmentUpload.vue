<template>
    <ValidationObserver v-slot="{ handleSubmit }">
        <div v-html="$error.handle(error)"/>
        <form @submit.prevent="handleSubmit(onSubmit)" class="form">
            <div class="form-group">
                <label class="control-label">Signed Commitment letter</label>
                <input type="file" ref="the_document" required name="attachment" class="form-control">
                <progress max="100"
                          :value.prop="uploadPercentage"></progress>
            </div>
            <div class="form-group">
                <button class="btn btn-info" type="submit"><i class="fa fa-upload"></i>Upload
                </button>
            </div>
        </form>
    </ValidationObserver>
</template>
<script>
export default {
    name: "CommitmentUpload",
    props: {
        submitUrl: {required: true, type: String},
    },
    data: () => ({
        error: '',
        loading: false,
        uploadPercentage: 0,
    }),
    methods: {
        onSubmit: function () {
            const myData = new FormData();
            let the_document = this.$refs.the_document.files[0];
            myData.append('attachment', the_document);
            this.loading = true;
            axios.post(this.submitUrl, myData, {
                headers: {'content-type': 'multipart/form-data'},
                onUploadProgress: function (progressEvent) {
                    this.uploadPercentage = parseInt(Math.round((progressEvent.loaded / progressEvent.total) * 100))
                }.bind(this)
            }).then(() => {
                this.loading = false;
                this.$toastr.s('Commitment letter uploaded', 'Saved');
                location.reload();
            }).catch(error => {
                this.loading = false;
                if (error.response) {
                    this.error = error.response;
                }
            });
        },
    }
}

</script>
