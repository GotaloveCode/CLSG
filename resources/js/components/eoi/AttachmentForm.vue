<template>
    <ValidationObserver v-slot="{ handleSubmit }">
        <div v-html="$error.handle(error)"/>
        <form @submit.prevent="handleSubmit(onSubmit)" class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th>Document Type</th>
                    <th>Document Name</th>
                    <th></th>
                </tr>
                </thead>
                <tr>
                 <ValidationProvider tag="td" name="Document Type" rules="required"
                                        v-slot="{ errors }">
                        <v-select label="name" placeholder="Select Document Type"
                                  v-model="document.document_type" :options="documents">
                        </v-select>
                        <span class="text-danger">{{ errors[0] }}</span>
                    </ValidationProvider>
                    <ValidationProvider tag="td" name="Document Name" rules="required"
                                        v-slot="{ errors }">
                        <input type="text" v-model="document.display_name" class="form-control">
                        <span class="text-danger">{{ errors[0] }}</span>
                    </ValidationProvider>

                    <ValidationProvider tag="td" name="Attachment" v-slot="{ validate, errors }"
                                        rules="required|ext:jpg,png,pdf,doc,docx,xls,xlsx,csv">
                       <span class="webkit"> <input type="file" ref="the_document" @change="validate" class="form-control"></span>

                        <div class="text-danger">{{ errors[0] }}</div>
                    </ValidationProvider>
                </tr>
                <tr><td colspan="2"></td><td><progress max="100" :value.prop="uploadPercentage"></progress></td></tr>
            </table>
            <button class="btn btn-warning" v-if="loading" type="submit">
                Sending <i class="feather icon-spin spinner"></i>
            </button>
            <button class="btn btn-primary" v-else type="submit">
                Submit <i class="feather icon-send"></i>
            </button>
        </form>
    </ValidationObserver>
</template>

<script>
import {ext} from "vee-validate/dist/rules";
import {extend} from "vee-validate";

extend("ext", ext);

export default {
    name: "AttachmentForm",
    props: {
        submitUrl: {required: true, type: String},
        documents: {required: true, type: Array},
    },
    data: () => ({
        error: '',
        loading: false,
        uploadPercentage:0,
        document: {
            document_type: null,
            display_name: ''
        }
    }),
    methods: {
        onSubmit: function () {
            const myData = new FormData();
            let the_document = this.$refs.the_document.files[0];
            myData.append('attachment', the_document);
            myData.append('display_name', this.document.display_name);
            myData.append('document_type', this.document.document_type);
            this.loading = true;
            axios.post(this.submitUrl, myData, {
                headers: {'content-type': 'multipart/form-data'},
                onUploadProgress: function (progressEvent) {
                    this.uploadPercentage = parseInt(Math.round((progressEvent.loaded / progressEvent.total) * 100))
                }.bind(this)
            }).then(() => {
                this.$toastr.s('Document uploaded', 'Saved');
                location.reload();
                this.loading = false;
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

<style>
.vs--searchable{
  width: 20rem !important;
}
.webkit{
    display: -webkit-box;
}
</style>
