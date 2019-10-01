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
                <div class="card author-box bg-white shadow-info shadow-lg">
                    <div class="card-header">
                        <h4 class="font-weight-bold">
                            TOTAL POIN <span> {{ totalPoin }}</span>
                        </h4>
                        <div class="card-header-action">
                            <button v-if="totalPoin >= setting[0].data.setting_value"
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
                            <div class="author-box-job text-uppercase">
                                {{bidan.desc}}
                                <br>
                                {{bidan.nomor}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4" v-for="v in this.poin_reward.data_history">
                        <div class="card shadow card-primary">
                            <div class="card-header text-uppercase d-flex">
                                <h4 :class="headerClass(v.status)">{{v.status}}</h4>
                                <small class="ml-auto">{{v.date}}</small>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-8">
                                        <strong v-if="v.status != 'reward'">{{v.name_patient}}</strong> <br>
                                        <small v-if="v.status != 'reward'">{{v.nik_patient}}</small>
                                    </div>
                                    <div class="col-4">
                                        <h5 :class="headerClass(v.status)" v-if="v.status != 'reward'">{{v.point}} PTS</h5>
                                        <h5 :class="headerClass(v.status)" v-else>- {{v.point}} PTS</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-primary btn-block mb-5" @click="loadMore">Muat lebih banyak</button>
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
                page:1,
                action: "store",
                title: "Reward",
                titleForm: "Tambah Reward",
                poin_reward:'',
                poin: {
                    balance: 0,
                    cash: 0
                },
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
                errors: [],
                selectData: {}
            };
        },
        computed: {
            setting(){
                return this.$store.state.setting;
            },
            id() {
                return this.$route.params.id;
            },
            totalPoin() {
                if(this.poin.balance !== 0 || this.poin.cash !== 0){
                    var total = this.poin.balance - this.poin.cash;
                    this.data.data.reward_point = total;
                }else{
                    var total = '0';
                }
                return total;
            }
        },
        methods: {
            getData() {
                this.$http.get(`/api/reward-poin-bidan/balance/${this.id}`).then(res => {
                    if(res.data.balance){
                        this.poin.balance = parseInt(res.data.balance);
                    }
                });
                this.$http.get(`/api/reward-poin-bidan/cash/${this.id}`).then(res => {
                    if(res.data.cash){
                        this.poin.cash = parseInt(res.data.cash);
                    }
                });
                this.$http.get(`/api/bidan/${this.id}`).then(res => {
                    this.bidan = res.data;
                });
                this.getHistoryPoin(false);

            },
            refresh() {
                this.getData();
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
            },
            loadMore(){
                this.getHistoryPoin(true);
            },
            getHistoryPoin(push) {
                if(push){
                    this.$http.post(`/mobile/user`,{
                        'act' : 'history',
                        'bidan_id' : this.id,
                        'page' : this.page,
                    }).then(res => {
                        if(res.data.status){
                            this.page++;
                            res.data.data_history.forEach(v=>{
                                this.poin_reward.data_history.push(v);
                            })
                        }else{
                            this.$noty.info("History tidak ditemukan")
                        }
                    });
                }else{
                    this.$http.post(`/mobile/user`,{
                        'act' : 'history',
                        'bidan_id' : this.id,
                        'page' : this.page,
                    }).then(res => {
                        this.poin_reward = res.data;
                    });
                }

            },
            headerClass(status) {
                if(status == 'checkup'){
                    return 'display-6 text-warning';
                }else if(status == 'reward'){
                    return 'display-6 text-primary';
                }else if(status == 'born'){
                    return 'display-6 text-danger';
                }
            },
        }
    };
</script>
