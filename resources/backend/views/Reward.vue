<template>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ title }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <router-link to="/bidan">Bidan</router-link>
                    </div>
                    <div class="breadcrumb-item">{{title}}</div>
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

                <user-component :value="bidan"></user-component>

                <div class="row">
                    <div class="col-md-3" v-for="v in lists">
                        <div class="card card-danger bg-secondary shadow-dark">
                            <div class="card-header">
                                <h4 class="text-danger">
                                    <span>{{v.data.reward_point}} POINT</span>
                                </h4>
                                <div class="card-header-action ml-auto">
                                    <button class="btn btn-edit btn-primary" @click="edit(v)">Edit</button>
                                    <button class="btn btn-destroy btn-danger" @click="destroy(v)">Hapus</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <p>
                                    {{v.tanggal_reward}}
                                </p>
                            </div>
                        </div>
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
            <input type="hidden" v-model="bidan.data.bidan_id">
            <div class="form-group">
                <text-input v-model="data.data.reward_point" label="Point" :error="errors.reward_point"></text-input>
            </div>

            <div class="form-group">
                <label>Tanggal</label>
                <date-picker v-model="data.data.reward_date"></date-picker>
                <small class="text-danger" v-if="errors.reward_date">{{ errors.reward_date.join() }}</small>
            </div>
        </modal>
    </div>
</template>

<script>
    import {ModelSelect} from "vue-search-select";
    import {mixin} from "../mixin";
    import Modal from "../components/Modal";
    import TextInput from "../components/input/Text";
    import UserComponent from "../components/UserComponent";
    import DatePicker from "../components/Datepicker";

    export default {
        mixins: [mixin],
        components: {
            Modal,
            ModelSelect,
            TextInput,
            UserComponent,
            DatePicker
        },
        created() {
            this.getData();
            this.data2 = this.data;
        },
        data() {
            return {
                action: "store",
                title: "Reward",
                titleForm: "Tambah Reward",
                lists: "",
                bidan:"",
                data: {
                    "data": {
                        "reward_id": "",
                        "bidan_id": this.$route.params.id,
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
        computed: {
            id() {
                return this.$route.params.id;
            }
        },
        methods: {
            getData() {
                this.$http.get(`/api/reward-bidan/${this.id}`).then(res => {
                    this.lists = res.data;
                });
                this.$http.get(`/api/bidan/${this.id}`).then(res => {
                    this.bidan = res.data;
                });
            },
            refresh() {
                this.getData();
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
                    data: this.data.data
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
                    data: this.data.data
                });
            },
            destroy(value)
            {
                var me = this;
                me.$swal({
                    title: "Apakah Kamu Yakin?",
                    type: "warning",
                    confirmButtonText: "Ya",
                    showCancelButton: true,
                    confirmButtonColor: me.$store.state.primary_color,
                    cancelButtonText: "Tidak"
                }).then(result => {
                    if (result.value) {
                        me.$http.delete(value.links.destroy).then(res => {
                            if (res.status) {
                                me.$noty.warning(res.data.message);
                                me.refresh();
                            }
                        });
                    }
                });
            }
        }
    };
</script>
