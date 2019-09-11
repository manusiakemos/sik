<template>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ title }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <router-link to="home">{{title}}</router-link>
                    </div>
                    <div class="breadcrumb-item">Pilih Pegawai</div>
                </div>
            </div>

            <div class="section-body">
                {{selected}}
                <div class="row mb-4">

                </div>
                <input type="hidden" v-model="selected">
                <select-pegawai ref="select-pegawai"></select-pegawai>
                <!-- end-datatables -->
            </div>
        </section>
    </div>
</template>

<script>
    import {ModelSelect} from "vue-search-select";
    import {mixin} from "../mixin";
    import Modal from "../components/Modal";
    import MyEditor from "../components/MyEditor";
    import DataTables from "../components/DataTables";
    import Role from "../components/Roles";
    import SelectPegawai from "../components/SelectPegawai";

    export default {
        mixins: [mixin],
        components: {
            Modal,
            ModelSelect,
            MyEditor,
            DataTables,
            Role,
            SelectPegawai
        },
        created() {
            this.data2 = this.data;
        },
        data() {
            return {
                action: "store",
                title: "Tambah User",
                titleForm: "Tambah User",
                configDt: {
                    url: "/api/user",
                    columns: [
                        {title: "Username", data: "username", class: "all"},
                        {title: "Role", data: "user_level", class: "all"},
                        {title: "Action", data: "action", class: "text-center"}
                    ]
                },
                data: {
                    password: "",
                    username: "",
                    links: {
                        store: "/api/user",
                        update: "",
                        destroy: ""
                    }
                },
                data2: null,
                errors: [],
                selectData: {}
            };
        },
        computed: {
            auth_user() {
                return this.$store.state.auth.user;
            },
            selected(){
                return this.$store.state.selected;
            }
        },
        mounted() {
            this.initActionDt();
        },
        methods: {
            initActionDt() {
                var me = this;
                $("#dt-user")
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
                this.titleForm = "Tambah User";
                this.showModal("#modal-create-user");
            },
            store() {
                this.sendData({
                    url: this.data.links.store,
                    method: "post",
                    data: {
                        nama: this.selected.pegawai_nama
                    }
                });
            },
            edit(value) {
                this.action = "update";
                this.data = _.cloneDeep(value);
                this.titleForm = "Edit User";
                this.showModal("#modal-user");
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
