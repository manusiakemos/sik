<template>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ title }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <router-link to="home">{{title}}</router-link>
                    </div>
                    <div class="breadcrumb-item">Datatables</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row mb-4">
                    <div class="col-lg-12 d-lg-flex">
                        <div class="mr-lg-auto">
                            <button
                                    class="btn btn-sm-block btn-dark mr-1 mt-2"
                                    @click="create"
                            >Tambah
                            </button>
                            <button type="button" class="btn btn-sm-block btn-dark mt-2 mr-1" @click="refresh">
                                Refresh
                            </button>
                        </div>
                    </div>
                </div>
                <!-- datatables -->
                <div class="card">
                    <div class="card-body">
                        <data-tables :url="configDt.url" :columns="configDt.columns" selector="dt-Berita"
                                     ref="dt"></data-tables>
                    </div>
                </div>
                <!-- end-datatables -->
            </div>
        </section>
        <!-- modal -->
        <modal
                :title="titleForm"
                :callback="submitForm"
                id="modal-Berita"
                ref="modal"
                class="modal"
        >
            <div v-if="action == 'update'">
                <img :src="data.gambar" alt="gambar" class="img-fluid mb-4" width="100%">
            </div>
            <div class="form-group">
                <label>Judul</label>
                <input type="text" class="form-control" v-model="data.judul">
                <small class="text-danger" v-if="this.errors.judul">{{ this.errors.judul.join() }}</small>

            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select-category type="text" v-model="data.cb_id"></select-category>
                <small class="text-danger" v-if="this.errors.kategori">{{ this.errors.kategori.join() }}</small>
            </div>
            <!-- <label class="text-info"> Link Generator </label>
             <strong>{{ _slug }}</strong>-->

            <div class="form-group">
                <label>Link</label>
                <input type="text" class="form-control" v-model="data.plain_url">
                <small class="text-danger" v-if="this.errors.link">{{ this.errors.link.join() }}</small>
            </div>
            <div class="form-group">
                <label>Isi Berita</label>
                <my-editor v-model="data.content"></my-editor>
                <small class="text-danger" v-if="this.errors.isi_berita">{{ this.errors.isi_berita.join() }}</small>

            </div>
            <div class="form-group">
                <label for="uploadFile">Upload File</label>
                <input type="file" class="form-control-file" id="uploadFile" ref="file"
                       v-on:change="handleFileUpload()">
            </div>
        </modal>
    </div>
</template>

<script>
    import {ModelSelect} from "vue-search-select";
    import {mixin} from "../mixin";
    import Modal from "../components/Modal";
    import MyEditor from "../components/MyEditor";
    import DataTables from "../components/DataTables";
    import YearPicker from "../components/YearPicker";
    import SelectCategory from "../../frontend/components/SelectBerita";

    export default {
        mixins: [mixin],
        components: {
            SelectCategory,
            Modal,
            ModelSelect,
            MyEditor,
            DataTables,
            YearPicker,
        },
        created() {
            this.data2 = this.data;
        },
        data() {
            return {
                action: "",
                title: "Manajemen Berita",
                titleForm: "Tambah Berita",
                configDt: {
                    url: "/api/berita",
                    columns: [
                        {title: "Judul", data: "berita_judul", class: "all"},
                        {title: "Status", data: "berita_aktif"},
                        {title: "Kategori", data: "category.cb_name"},
                        {title: "Publisher", data: "user.name"},
                        {title: "View", data: "berita_hit"},
                        {title: "Action", data: "action", class: "text-center all"}
                    ]
                },
                data: {
                    "data": {
                        "cb_id": "",
                        "status": 1,
                        "plain_url": "",
                        "judul": "",
                        "slug": "",
                        "gambar": "",
                        "content": "",
                    },
                    "links": {
                        "store": "/api/berita",
                        "update" : "",
                        "destory" : ""
                    }
                },
                data2: null,
                errors: [],
                selectData: {}
            };
        },
        computed:{
            _slug(){
                return _.kebabCase(this.data.judul);
            }
        },
        watch:{
            'data.judul':function (newValue) {
                this.data.plain_url = _.kebabCase(newValue);
            }
        },
        mounted() {
            this.initActionDt();
        },
        methods: {
            handleFileUpload() {
                this.data.file = this.$refs.file.files[0];
            },
            initActionDt() {
                var me = this;
                $("#dt-Berita")
                    .on("click", ".btn-edit", function (e) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        me.$http.get($(this).attr("href")).then(res => {
                            me.edit(res.data);
                        });
                    })
                    .on("click", ".btn-destroy", function (e) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        me.$swal({
                            title: "Apakah Kamu Yakin?",
                            type: "warning",
                            confirmButtonText: "Ya",
                            showCancelButton: true,
                            confirmButtonColor: me.$store.state.primary_color,
                            cancelButtonText: "Tidak"
                        }).then(result => {
                            if (result.value) {
                                me.$http.delete($(this).attr("href")).then(res => {
                                    if (res.status) {
                                        me.$noty.warning(res.data.message);
                                        me.refresh();
                                    }
                                });
                            }
                        });
                    });
            },
            refresh() {
                this.$refs.dt.refresh();
            },
            submitForm() {
                if(this.action == 'store'){
                    this.store();
                }else{
                    this.update();
                }
            },
            create() {
                this.action = "store";
                $("[type=file]").val("");
                this.data = _.cloneDeep(this.data2);
                this.titleForm = "Tambah Berita";
                this.showModal("#modal-Berita");
            },
            store() {
                let formData = new FormData();
                formData.append('file', this.data.file);
                formData.append('judul', this.data.judul);
                formData.append('kategori', this.data.cb_id);
                formData.append('link', this.data.plain_url);
                formData.append('isi_berita', this.data.content);
                this.sendData({
                    url: this.data.links.store,
                    method: "POST",
                    data: formData,
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                });
            },
            edit(value) {
                this.action = "update";
                $("[type=file]").val("");
                this.data = _.cloneDeep(value);
                this.titleForm = "Edit Berita";
                this.showModal("#modal-Berita");
            },
            update() {
                let formData = new FormData();
                formData.append('file', this.data.file);
                formData.append('judul', this.data.judul);
                formData.append('kategori', this.data.cb_id);
                formData.append('link', this.data.plain_url);
                formData.append('isi_berita', this.data.content);
                formData.append('_method', 'PUT');
                this.sendData({
                    url: this.data.links.update,
                    method: "POST",
                    data: formData,
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    }
                });
            }
        }
    };
</script>
