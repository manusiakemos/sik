<template>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ title }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <router-link to="home">{{title}}</router-link>
                    </div>
                    <div class="breadcrumb-item">Setting</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row mb-4">
                    <div class="col-lg-12 d-lg-flex">
                        <div class="mr-lg-auto">
                           <!-- <button
                                    class="btn btn-sm-block btn-dark mr-1 mt-2"
                                    @click="create"
                            >Tambah Setting
                            </button>-->
                            <button type="button" class="btn btn-sm-block btn-dark mt-2 mr-1" @click="refresh">
                                Refresh
                            </button>
                        </div>
                    </div>
                </div>
                <!-- datatables -->
                <div class="card card-primary" v-for="value in lists">
                    <div class="card-header">
                        <h4 class="text-uppercase">
                            {{value.data.setting_name}}
                        </h4>
                        <div class="card-header-action">
                            <button class="btn btn-dark" @click="edit(value)">Edit</button>
                            <!--<button class="btn btn-dark" @click="destroy(value)">Destroy</button>-->
                        </div>
                    </div>
                    <div class="card-body">
                       <!--<div v-html="value.data.value"></div>-->
                        {{value.data.setting_value}}
                    </div>
                </div>
                <!-- end-datatables -->
            </div>
        </section>
        <!-- modal -->
        <modal
                :title="titleForm"
                :callback="action == 'store' ? store : update"
                id="modal-setting"
                ref="modal"
                class="modal"
        >
            <!--<div class="form-group">-->
                <!--<label>Nama</label>-->
                <!--<input type="text" class="form-control" v-model="data.data.name"/>-->
                <!--<small class="text-danger" v-if="this.errors.name">{{ this.errors.name.join() }}</small>-->
            <!--</div>-->
            <!--<div class="form-group">-->
                <!--<label>Value</label>-->
                <!--<my-editor v-model="data.data.value"></my-editor>-->
                <!--<small class="text-danger" v-if="this.errors.value">{{ this.errors.value.join() }}</small>-->
            <!--</div>-->
            <div class="form-group">
                <label>Value</label>
                <input type="text" class="form-control" v-model="data.data.setting_value"/>
                <small class="text-danger" v-if="this.errors.setting_value">{{ this.errors.setting_value.join() }}</small>
            </div>
        </modal>
    </div>
</template>

<script>
    import {mixin} from "../mixin";
    import Modal from "../components/Modal";
    import MyEditor from "../components/MyEditor";

    export default {
        mixins: [mixin],
        components: {
            Modal,
            MyEditor,
        },
        created() {
            this.data2 = this.data;
        },
        data() {
            return {
                action: "store",
                title: "Setting",
                titleForm: "Tambah Setting",
                lists: '',
                data: {
                    "data": {
                        "id": "",
                        "name": "",
                        "value": "",
                        "created_at": null,
                        "updated": null
                    },
                    "links": {
                        "store": "http://localhost:8000/api/setting",
                        "update": "http://localhost:8000/api/setting/1",
                        "destroy": "http://localhost:8000/api/setting/1"
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
                this.$http.get('/api/setting').then(res => {
                    this.lists = res.data;
                    this.$store.commit("_setting", res.data);
                })
            },
            refresh() {
                this.$noty.info('refresh data');
                this.initActionDt();
            },
            create() {
                this.data = _.cloneDeep(this.data2);
                this.action = "store";
                this.titleForm = "Tambah Setting";
                this.showModal("#modal-setting");
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
                this.titleForm = "Edit Setting";
                this.showModal("#modal-setting");
            },
            update() {
                this.sendData({
                    url: this.data.links.update,
                    method: "put",
                    data: this.data.data
                });
            },
            destroy(value) {
                this.$swal({
                    title: "Apakah Kamu Yakin?",
                    type: "warning",
                    confirmButtonText: "Ya",
                    showCancelButton: true,
                    confirmButtonColor: this.$store.state.primary_color,
                    cancelButtonText: "Tidak"
                }).then(result => {
                    if (result.value) {
                        this.$http.delete(value.links.destroy).then(res => {
                            if (res.status) {
                                this.$noty.warning(res.data.message);
                                this.refresh();
                            }
                        });
                    }
                });
            }
        }
    };
</script>
