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
                        <input type="file" ref="the_document" @change="validate" class="form-control">
                        <span class="text-danger">{{ errors[0] }}</span>
                    </ValidationProvider>
                </tr>
            </table>
            <button class="btn btn-primary" type="submit">
                Submit
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
        document: {
            document_type: null,
            display_name: ''
        }
    }),
    methods: {
        onSubmit() {
            const myData = new FormData();
            let the_document = this.$refs.the_document.files[0];
            myData.append('attachment', the_document);
            myData.append('display_name', this.document.display_name);
            myData.append('document_type', this.document.document_type);

            axios.post(this.submitUrl, myData, {headers: {'content-type': 'multipart/form-data'}}).then(() => {
                this.$toastr.s('Document uploaded', 'Saved');
                location.reload();
            }).catch(error => {
                if (error.response) {
                    this.error = error.response;
                }
            });
        },
    }
}
</script>

