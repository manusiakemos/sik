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
                            >Tambah Kategori Berita
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
                        <data-tables :url="configDt.url" :columns="configDt.columns" selector="dt-Kategori-Berita"
                                     ref="dt"></data-tables>
                    </div>
                </div>
                <!-- end-datatables -->
            </div>
        </section>
        <!-- modal -->
        <modal
                :title="titleForm"
                :callback="action == 'store' ? store : update"
                id="modal-category"
                ref="modal"
                class="modal"
        >
            <div class="form-group">
                <label>Nama Kategori Berita</label>
                <input type="text" class="form-control" v-model="data.nama_kategori"/>
                <small class="text-danger" v-if="this.errors.nama_kategori">{{ this.errors.nama_kategori.join() }}</small>
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

    export default {
        mixins: [mixin],
        components: {
            Modal,
            ModelSelect,
            MyEditor,
            DataTables,
        },
        created() {
            this.data2 = this.data;
        },
        data() {
            return {
                action: "store",
                title: "Kategori Berita",
                titleForm: "Tambah Kategori Berita",
                configDt: {
                    url: "/api/category-berita",
                    columns: [
                        {title: "Nama", data: "cb_name"},
                        {title: "Action", data: "action", class: "text-center"}
                    ]
                },
                data: {
                    nama_kategori: "",
                    links: {
                        store: "/api/category-berita",
                        update: "",
                        destroy: ""
                    }
                },
                data2: null,
                errors: [],
                selectData: {}
            };
        },
        mounted() {
            this.initActionDt();
        },
        methods: {
            initActionDt() {
                var me = this;
                $("#dt-Kategori-Berita")
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
            create() {
                this.data = _.cloneDeep(this.data2);
                this.action = "store";
                this.titleForm = "Tambah Kategori Berita";
                this.showModal("#modal-category");
            },
            store() {
                this.sendData({
                    url: this.data.links.store,
                    method: "post",
                    data: this.data
                });
            },
            edit(value) {
                this.action = "update";
                this.data = _.cloneDeep(value);
                this.titleForm = "Edit Kategori Berita";
                this.showModal("#modal-category");
            },
            update() {
                this.sendData({
                    url: this.data.links.update,
                    method: "put",
                    data: this.data
                });
            }
        }
    };
</script>
