<template>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ title }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <router-link to="home">{{title}}</router-link>
                    </div>
                    <div class="breadcrumb-item">User Datatables</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row mb-4">
                    <div class="col-lg-12 d-lg-flex">
                        <div class="mr-lg-auto">
                            <button
                                    class="btn btn-sm-block btn-dark mr-1 mt-2"
                                    @click="create"
                            >Tambah User
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
                        <data-tables :url="configDt.url" :columns="configDt.columns" selector="dt-user"
                                     ref="dt"></data-tables>
                    </div>
                </div>
                <!-- end-datatables -->
            </div>
        </section>
        <!-- modal tambah user-->
        <modal
                :title="titleForm"
                :callback="action == 'store' ? store : update"
                id="modal-create-user"
                ref="modalCreateUser"
                class="modal"
        >
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" v-model="data.data.username"/>
                <small class="text-danger" v-if="this.errors.username">{{ this.errors.username.join() }}</small>
            </div>
            <div class="form-group">
                <label>Role</label>
                <role v-model="data.data.role"/>
                <small class="text-danger" v-if="this.errors.role">{{ this.errors.role.join() }}</small>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" autocomplete="new-password" class="form-control" v-model="data.data.password"/>
                <small class="text-danger" v-if="this.errors.password">{{ this.errors.password.join() }}</small>
            </div>

            <div class="form-group">
                <label>Password Confirmation</label>
                <input type="password" autocomplete="new-password" class="form-control" v-model="data.data.password_confirmation"/>
                <small class="text-danger" v-if="this.errors.password_confirmation">{{ this.errors.password_confirmation.join() }}</small>
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
    import Role from "../components/Roles";

    export default {
        mixins: [mixin],
        components: {
            Modal,
            ModelSelect,
            MyEditor,
            DataTables,
            Role,
        },
        created() {
            this.data2 = this.data;
        },
        data() {
            return {
                action: "store",
                title: "Manajemen User",
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
                    data:{
                        password: "",
                        password_confirmation:"",
                        username: "",
                        role:"",
                    },
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
                    data: this.data.data
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
                    data: this.data.data
                });
            }
        }
    };
</script>
