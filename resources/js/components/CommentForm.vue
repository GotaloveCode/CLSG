<template>
    <ValidationObserver v-slot="{ handleSubmit }">
        <div v-html="$error.handle(error)"></div>
        <form @submit.prevent="handleSubmit(onSubmit)" class="col-md-12 mt-1">
            <ValidationProvider name="Comment" rules="required" v-slot="{ errors }"
                                class="row form-group">
                <label class="control-label col-md-12">Leave your comment below</label>
                <tinymce id="da" placeholder="Leave your comment" v-model="description"/>
                <span class="ml-2 text-danger"> {{ errors[0] }}</span>
            </ValidationProvider>
            <button class="btn btn-warning" v-if="loading" type="submit">
                Sending <i class="feather icon-loader"></i>
            </button>
            <button class="btn btn-info" v-else type="submit">
                Comment <i class="feather icon-check-circle"></i>
            </button>
        </form>
    </ValidationObserver>
</template>

<script>
import tinymce from 'vue-tinymce-editor'

export default {
    name: "CommentForm",
    components: {
        tinymce
    },
    props: {
        submitUrl: {required: true, type: String},
    },
    data() {
        return {
            error:'',
            description: '',
            loading: false
        };
    },
    methods: {
        onSubmit() {
            this.loading = true;
            axios.post(this.submitUrl, {
                description: this.description
            }).then(response => {
                this.$toastr.s(response.data.message, "Success");
                location.reload();
            }).catch(error => {
                this.error = error.response;
            }).finally(() => {
                this.loading = false;
            });
        }
    }
}
</script>
