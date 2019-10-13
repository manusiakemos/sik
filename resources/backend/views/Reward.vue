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
                <div class="card author-box bg-info shadow-info shadow-lg">
                    <div class="card-header">
                        <h4 class="text-white font-weight-bold">
                            TOTAL POIN <span v-if="totalPoin"> {{ totalPoin }}</span>
                        </h4>
                        <div class="card-header-action">
                            <button
                                    v-if="totalPoin >= setting_reward"
                                    class="btn btn-sm-block btn-primary mr-1 mt-2 shadow-lg"
                                    @click="create"
                            >Beri Reward
                            </button>
                            <button type="button" class="btn btn-sm-block btn-warning mr-1 mt-2 shadow-lg mt-2 mr-1"
                                    @click="refresh">
                                Refresh Poin
                            </button>
                        </div>
                    </div>
                    <div class="card-body" v-if="bidan.data">
                        <div class="author-box-left">
                            <img alt="image" :src="bidan.user_resource.avatar" class="rounded-circle author-box-picture"
                                 style="width: 80px;">
                            <div class="clearfix"></div>
                        </div>
                        <div class="author-box-details">
                            <div class="author-box-name">
                                {{bidan.data.bidan_nama}}
                            </div>
                            <div class="author-box-job text-white text-uppercase">
                                {{bidan.desc}}
                                <br>
                                {{bidan.nomor}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header"><h4>Riwayat</h4></div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <div class="list-group w-100">
                                        <div class="list-group-item" v-for="value in rewards">
                                            <div class="d-md-flex justify-content-between">
                                                <h6 class="text-primary"> {{value.date}} {{value.status}}</h6>
                                                <h6 class="text-primary" v-if="value.status=='reward'"> -
                                                    {{value.point}} POIN</h6>
                                                <h6 class="text-info" v-else> {{value.point}} POIN</h6>
                                            </div>
                                            <div>
                                                <p v-if="value.status !='reward'">
                                                    Pasien dengan NIK
                                                    {{value.nik_patient}} an. {{
                                                    value.name_patient }}</p>
                                                <p v-if="value.note">{{value.note}}</p>
                                            </div>
                                        </div>
                                    </div>
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
    import {ModelSelect} from "vue-search-select";
    import {mixin} from "../mixin";
    import Modal from "../components/Modal";
    import TextInput from "../components/input/Text";
    import UserComponent from "../components/UserComponent";

    export default {
        mixins: [mixin],
        components: {
            Modal,
            ModelSelect,
            TextInput,
            UserComponent,
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
                poin: {
                    balance: 0,
                    cash: 0
                },
                page: 1,
                setting_reward: '',
                lists: "",
                bidan: "",
                data: {
                    "data": {
                        "bidan_id": this.$route.params.id,
                        "reward_point": "",
                    },
                    "links": {
                        "store": "/api/reward",
                        "update": "",
                        "destroy": ""
                    }
                },
                data2: null,
                rewards: '',
                errors: [],
                selectData: {}
            };
        },
        computed: {
            id() {
                return this.$route.params.id;
            },
            totalPoin() {
                if (this.poin.balance !== 0 || this.poin.cash !== 0) {
                    var total = this.poin.balance - this.poin.cash;
                    this.data.data.reward_point = total;
                } else {
                    var total = '0';
                }
                return total;
            }
        },
        methods: {
            getData() {
                this.$http.get(`/api/reward-poin-bidan/balance/${this.id}`).then(res => {
                    if (res.data.balance) {
                        this.poin.balance = parseInt(res.data.balance);
                    }
                });
                this.$http.get(`/api/reward-poin-bidan/cash/${this.id}`).then(res => {
                    if (res.data.cash) {
                        this.poin.cash = parseInt(res.data.cash);
                    }
                });
                this.$http.get(`/api/bidan/${this.id}`).then(res => {
                    this.bidan = res.data;
                });
                this.$http.get('/api/setting/6').then(res => {
                    this.setting_reward = res.data.setting_value;
                });
                this.$http.get(`/api/reward-bidan/get-history/${this.page}/${this.id}`).then(res => {
                    this.rewards = res.data;
                })
            },
            refresh() {
                this.getData();
                this.$noty.info('refresh');
            },
            create() {
                this.data = _.cloneDeep(this.data2);
                this.action = "store";
                this.store()
            },
            store(value) {
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
                        me.sendData({
                            url: me.data.links.store,
                            method: "post",
                            data: me.data.data
                        });
                    }
                });
            }
        }
    };
</script>
