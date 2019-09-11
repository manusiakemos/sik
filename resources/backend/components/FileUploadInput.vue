<template>
    <div class="modal modal-import fade" tabindex="-1" role="dialog" id="modal-import">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="uploadFile">Upload File</label>
                        <input type="file" class="form-control-file" id="uploadFile" ref="file"
                               v-on:change="handleFileUpload()">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" @click="submitFiles">Upload</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props: ['url'],
        name: "Upload File",
        methods: {
            handleFileUpload() {
                this.file = this.$refs.file.files[0];
            },
            submitFiles() {
                let formData = new FormData();
                formData.append('file', this.file);
                axios.post(this.url,
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data',
                            'Authorization': `Bearer ${this.$store.state.auth.user.api_token}`
                        }
                    }
                ).then(res => {
                    this.$noty.warning(res.data.message);
                    this.$parent.refresh();
                }).catch(err => {
                    console.log(err.response);
                    this.$noty.error("Upload File Gagal");
                });
            },
        },
        data() {
            return {
                file: ''
            }
        },
    }
</script>

<style scoped>

</style>
