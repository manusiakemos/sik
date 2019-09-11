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
                            >Tambah Puskesmas
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
                        <data-tables :url="configDt.url" :columns="configDt.columns" selector="dt-puskemas"
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
                <label>Nama</label>
                <input type="text" class="form-control" v-model="data.data.puskesmas_nama"/>
                <small class="text-danger" v-if="this.errors.puskesmas_nama">{{ this.errors.puskesmas_nama.join() }}</small>
            </div>
            <div class="form-group">
                <label>Nomor</label>
                <input type="text" class="form-control" v-model="data.data.puskesmas_no"/>
                <small class="text-danger" v-if="this.errors.puskesmas_no">{{ this.errors.puskesmas_no.join() }}</small>
            </div>
            <div class="form-group">
                <label>Kecamatan</label>
                <kecamatan v-model="data.data.kecamatan_id"/>
                <small class="text-danger" v-if="this.errors.kecamatan_id">{{ this.errors.kecamatan_id.join() }}</small>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <my-editor v-model="data.data.puskesmas_alamat"/>
                <small class="text-danger" v-if="this.errors.puskesmas_alamat">{{ this.errors.puskesmas_alamat.join() }}</small>
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
    import Kecamatan from "../components/Kecamatan";

    export default {
        mixins: [mixin],
        components: {
            Kecamatan,
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
                title: "Puskesmas",
                titleForm: "Tambah Puskesmas",
                configDt: {
                    url: "/api/puskesmas",
                    columns: [
                        {title: "Nama", data: "puskesmas_nama", class:"all"},
                        {title: "No", data: "puskesmas_no"},
                        {title: "Alamat", data: "puskesmas_alamat"},
                        {title: "Kecamatan", data: "kecamatan.kecamatan_nama"},
                        {title: "Action", data: "action", class: "text-center all"}
                    ]
                },
                data: {
                    "data": {
                        "puskesmas_id": "",
                        "kecamatan_id": "",
                        "puskesmas_no": "",
                        "puskesmas_nama": "",
                        "puskesmas_alamat": "",
                        "created_at": "",
                        "updated_at": "",
                        "deleted_at": ""
                    },
                    "links": {
                        "store": "/api/puskesmas",
                        "update": "/api/puskesmas/6",
                        "destroy": "/api/puskesmas/6"
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
                $("#dt-puskemas")
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
                this.titleForm = "Tambah Puskesmas";
                this.showModal("#modal-category");
            },
            store() {
                this.sendData({
                    url: this.data.links.store,
                    method: "post",
                    data: this.data.data
                });
            },
            edit(value) {
                this.action = "update";
                this.data = _.cloneDeep(value);
                this.titleForm = "Edit Puskesmas";
                this.showModal("#modal-category");
            },
            update() {
                this.sendData({
                    url: this.data.links.update,
                    method: "put",
                    data: this.data.data
                });
            }
        }
    };
</script>
