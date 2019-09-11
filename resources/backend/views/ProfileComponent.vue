<template>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Profile</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <a href="#">Profile</a>
                    </div>
                    <div class="breadcrumb-item">Profile</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title" v-if="data.user_data">{{ data.user_data.Nama }}</h2>
                <p class="section-lead text-uppercase" v-if="data.user_data">Role Level {{ data.role }}</p>

                <div class="row mt-sm-4">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card profile-widget">
                            <div class="profile-widget-header">
                                <div id="avatar-wrapper" class="d-none d-lg-block mr-md-5">
                                    <div class="profile-widget-picture rounded-circle overflow-hidden">
                                        <img @click="toggleShow" id="avatar-image" class="img-fluid" :src="data.avatar">
                                        <div id="avatar-overlay-image" @click="toggleShow">
                                            <span class="fa fa-camera fa-2x"></span>
                                        </div>
                                    </div>
                                </div>
                                <my-upload
                                        v-model="show"
                                        langType="in"
                                        :width="300"
                                        :height="300"
                                        @crop-success="uploadFile"
                                ></my-upload>
                            </div>
                            <div class="profile-widget-description">
                                <div class="profile-widget-name table-responsive">
                                    <form action="#" class="form" v-on:submit.prevent="updateProfile">
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input type="text" v-model="data.username" class="form-control">
                                            <small class="text-danger" v-if="this.errors.username">{{
                                                this.errors.username.join() }}
                                            </small>

                                        </div>
                                        <!--<div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" v-model="data.name" class="form-control">
                                            <small class="text-danger" v-if="this.errors.name">{{
                                                this.errors.name.join() }}
                                            </small>

                                        </div>-->
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" v-model="data.password" class="form-control">
                                            <small class="text-danger" v-if="this.errors.password">{{
                                                this.errors.password.join() }}
                                            </small>
                                        </div>
                                        <div class="form-group">
                                            <label>Password Confirmation</label>
                                            <input type="password" v-model="data.password_confirmation"
                                                   class="form-control">
                                            <small class="text-danger" v-if="this.errors.password_confirmation">{{
                                                this.errors.password_confirmation.join() }}
                                            </small>
                                        </div>

                                        <button class="mt-3 btn-submit btn btn-primary float-right" type="submit">
                                            Simpan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
    import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
    import myUpload from "vue-image-crop-upload";

    export default {
        components: {
            "my-upload": myUpload
        },
        data() {
            return {
                //cropper
                show: false,
                //ckeditor
                editor: ClassicEditor,
                editorConfig: {
                    toolbar: [
                        "heading",
                        "|",
                        "bold",
                        "italic",
                        "link",
                        "bulletedList",
                        "numberedList",
                        "blockQuote"
                    ]
                },
                //data ajax
                data: {},
                //errors laravel validation
                errors: []
            };
        },
        created() {
            this.fetchData();
        },
        methods: {
            fetchData() {
                var me = this;
                this.$http.get("/api/profile").then(function (res) {
                    if (res.status == 200) {
                        me.data = res.data;
                    }
                });
            },
            toggleShow() {
                this.show = !this.show;
            },
            uploadFile(imageDataUrl, field) {
                var me = this;
                this.$http.post(this.data.links.avatar, {
                        image: imageDataUrl
                    })
                    .then(function (res) {
                        if (res.status == 200) {
                            var d = res.data;
                            me.data = d.data;
                            me.$store.commit("_profile", d.data);
                            me.$noty.info(d.message);
                        }
                    });
            },
            updateProfile() {
                var me = this;
                var d = me.data;
                me.errors = [];
                me.$noty.info("loading...");

                this.$http
                    .put(this.data.links.update, d)
                    .then(res => {
                        var d = res.data;
                        me.$store.commit("_profile", d.data);
                        me.$noty.info(d.message);
                    })
                    .catch(error => {
                        var d = error.response.data;
                        var err = d.errors;
                        me.$noty.error(d.message);
                        me.errors = err;
                    });
            }
        }
    };
</script>
