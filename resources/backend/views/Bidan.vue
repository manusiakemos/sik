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
                                    v-if="$store.state.auth.user.role != 'dinkes'"
                                    class="btn btn-sm-block btn-dark mr-1 mt-2"
                                    @click="create"
                            >Tambah Bidan
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
                        <data-tables :url="configDt.url" :columns="configDt.columns" selector="dt-Bidan"
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
                id="modal-bidan"
                ref="modal"
                class="modal"
        >

            <div class="form-group">
                <text-input v-model="data.data.bidan_nama" label="Nama Bidan" :error="errors.bidan_nama"></text-input>
            </div>

            <div class="form-group">
                <text-input v-model="data.data.bidan_nik" label="NIK" :error="errors.bidan_nik"></text-input>
            </div>
            <div class="form-group">
                <text-input v-model="data.data.bidan_telp" label="Telp" :error="errors.bidan_telp"></text-input>
            </div>

            <div class="d-flex d-inline-block">
                <div class="mr-5">
                    <toggle-button :sync="true" v-model="data.data.bidan_pns" :labels="{checked: 'PNS', unchecked: 'Non PNS'}" :height="30" :width="90"/>
                </div>
                <div>
                    <toggle-button :sync="true" v-model="data.data.bidan_statis" :labels="{checked: 'Statis', unchecked: 'Non Statis'}" :height="30" :width="90"/>
                </div>
            </div>

            <div v-if="data.data.bidan_pns">
                <div class="form-group">
                    <text-input v-model="data.data.bidan_nip" label="NIP"
                                :error="errors.bidan_nip"></text-input>
                </div>
            </div>

            <div v-else>
                <div class="form-group">
                    <text-input v-model="data.data.bidan_nomor" label="Nomor Bidan"
                                :error="errors.bidan_nomor"></text-input>
                </div>
            </div>

            <div v-if="data.data.bidan_statis">
                <div class="form-group">
                    <label>Puskesmas</label>
                    <select-puskesmas v-model="data.data.puskesmas_id"></select-puskesmas>
                </div>
            </div>

            <div v-else>
                <div class="form-group">
                    <label>Kelurahan</label>
                    <select-kelurahan v-model="data.data.kelurahan_id"></select-kelurahan>
                </div>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <text-editor v-model="data.data.bidan_alamat"></text-editor>
            </div>

        </modal>
    </div>
</template>

<script>
    import {ModelSelect} from "vue-search-select";
    import {ToggleButton} from "vue-js-toggle-button";
    import {mixin} from "../mixin";
    import Modal from "../components/Modal";
    import DataTables from "../components/DataTables";
    import TextInput from "../components/input/Text";
    import SelectPuskesmas from "../components/Puskesmas";
    import SelectKelurahan from "../components/Kelurahan";
    import TextEditor from  "../components/MyEditor";

    export default {
        mixins: [mixin],
        components: {
            Modal,
            ModelSelect,
            DataTables,
            TextInput,
            ToggleButton,
            SelectKelurahan,
            SelectPuskesmas,
            TextEditor
        },
        created() {
            this.data2 = this.data;
        },
        data() {
            return {
                action: "",
                title: "Bidan",
                titleForm: "Tambah Bidan",
                configDt: {
                    url: "/api/bidan",
                    columns: [
                        {title: "Nama", data: "bidan_nama", class: "all text-capitalize"},
                        {title: "NIK", data: "bidan_nik", class: "text-capitalize"},
                        {title: "Poin", data: "poin", class: "text-capitalize"},
                        {title: "PNS", data: "bidan_pns", class: "text-capitalize"},
                        {title: "NIP", data: "bidan_nip", class: "text-capitalize"},
                        {title: "Nomor", data: "bidan_nomor", class: "text-capitalize"},
                        {title: "Statis", data: "bidan_statis", class: "text-capitalize"},
                        {title: "Puskesmas", data: "puskesmas_nama", name:"_puskesmas.puskesmas_nama", class: "text-capitalize"},
                        {title: "Kelurahan", data: "kelurahan_nama", name:"_kelurahan.kelurahan_nama", class: "text-capitalize"},
                        {title: "Alamat", data: "bidan_alamat", class: "text-capitalize"},

                        {title: "Action", data: "action", class: "text-center all"}
                    ]
                },
                data: {
                    "data": {
                        "bidan_pns" : false,
                        "bidan_statis": false,
                        "kelurahan_id": "",
                        "puskesmas_id": "",
                        "bidan_nik": "",
                        "bidan_alamat": "",
                        "bidan_nip": "",
                        "bidan_nomor": "",
                        "bidan_nama": "",
                        "bidan_telp": "",
                    },
                    "links": {
                        "store": "/api/bidan",
                        "update": "",
                        "destroy": ""
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
                $("#dt-Bidan")
                    .on("click", ".btn-edit", function (e) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        me.$http.get($(this).attr("href")).then(res => {
                            res.data.data.bidan_pns = res.data.data.bidan_pns == '1';
                            res.data.data.bidan_statis = res.data.data.bidan_statis == '1';
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
                    })
                    .on("click", ".btn-reward", function(e){
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        var id = $(this).data('id');
                        me.$router.push({path:`/reward/${id}`});
                    });
            },
            refresh() {
                this.$refs.dt.refresh();
            },
            submitForm() {
                if (this.action == 'store') {
                    this.store();
                } else {
                    this.update();
                }
            },
            create() {
                this.action = "store";
                $("[type=file]").val("");
                this.data = _.cloneDeep(this.data2);
                this.titleForm = "Tambah Bidan";
                this.showModal("#modal-bidan");
            },
            store() {
                this.sendData({
                    url: this.data.links.store,
                    method: "POST",
                    data: this.data.data
                });
            },
            edit(value) {
                this.action = "update";
                $("[type=file]").val("");
                this.data = _.cloneDeep(value);
                this.titleForm = "Edit Bidan";
                this.showModal("#modal-bidan");
            },
            update() {
                this.sendData({
                    url: this.data.links.update,
                    method: "PUT",
                    data: this.data.data
                });
            }
        }
    };
</script>
