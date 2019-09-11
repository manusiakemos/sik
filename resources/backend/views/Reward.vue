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
                            >Tambah Reward
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
                        {{this.$route.params.id}}
                        <data-tables :url="configDt.url" :columns="configDt.columns" selector="dt-Reward"
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

        </modal>
    </div>
</template>

<script>
    import {ModelSelect} from "vue-search-select";
    import {mixin} from "../mixin";
    import Modal from "../components/Modal";
    import DataTables from "../components/DataTables";
    import TextInput from "../components/input/Text";

    export default {
        mixins: [mixin],
        components: {
            Modal,
            ModelSelect,
            DataTables,
            TextInput
        },
        created() {
            this.data2 = this.data;
        },
        data() {
            return {
                action: "store",
                title: "Reward",
                titleForm: "Tambah Reward",
                configDt: {
                    url: "/api/reward",
                    columns: [
                        {title: "Nama Bidan", data: "bidan.bidan_nama" , class:"text-capitalize all"},
                        {title: "Poin", data: "reward_point"},
                        {title: "Tanggal", data: "reward_date"},
                        {title: "Action", data: "action", class: "text-center all"}
                    ]
                },
                data: {
                    "data": {
                        "reward_id": "",
                        "bidan_id": "",
                        "reward_point": "",
                        "reward_date": "",
                        "created_at": "",
                        "updated_at": ""
                    },
                    "links": {
                        "store": "/api/reward",
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
                $("#dt-Reward")
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
                this.titleForm = "Tambah Reward";
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
                this.titleForm = "Edit Reward";
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
