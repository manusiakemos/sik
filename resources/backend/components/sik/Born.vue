<template>
    <div>
        <!--form dan list card -->
        <div class="row">
            <div class="col-12">
                <div class="form-group m-0">
                    <el-input placeholder="filter data"
                              v-model="search" @change="getData">
                        <el-button slot="append" icon="el-icon-search"></el-button>
                    </el-input>
                </div>
            </div>
            <div class="col-lg-4" v-for="v in lists.data">
                <div class="card border shadow-sm mt-4 mb-0">
                    <div class="card-header">
                        <h4 class="text-danger" v-if="status=='born'">{{v.data.pp_code}}</h4>
                        <h4 class="mb-1 text-success" v-else-if="status=='done'">{{v.data.pp_code}}</h4>
                        <h4 class="mb-1 text-primary" v-else>{{v.data.pp_code}}</h4>
                        <div class="card-header-action">
                            <button class="btn btn-dark ml-auto" @click="showDetail(v)">Detail</button>
                            <button class="btn btn-dark ml-1" @click="showRiwayat(v)">Riwayat</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div v-if="v.data">
                            <table class="table table-sm">
                                <tr>
                                    <td colspan="2">
                                        <select-status v-model="v.data.pp_status" @input="save(v)"></select-status>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nama Pasien</td>
                                    <td>: {{ v.data.pp_nama_ibu}}</td>
                                </tr>
                                <tr>
                                    <td>Nama Ayah</td>
                                    <td>: {{ v.data.pp_nama_ayah}}</td>
                                </tr>
                                <tr>
                                    <td>Nama Anak</td>
                                    <td>: {{ v.data.pp_nama_anak}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="d-flex w-100">
                            <small class="text-dark ml-auto" v-if="status == 'done'">
                                {{v.mod.update_to_done}}
                            </small>
                            <small class="text-dark ml-auto" v-else-if="status == 'born'">
                                Ditambahkan oleh {{v.bidan.bidan_nama }} pada {{v.mod.update_to_born}}
                            </small>
                            <small class="text-dark ml-auto" v-else>
                                {{v.mod.update_to_send}}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <button class="btn btn-outline-dark btn-block mt-5 mb-5" @click="loadMore">Muat lebih banyak</button>
            </div>
        </div>
    </div>
</template>

<script>
    import SelectStatus from "../../components/sik/SelectStatus";
    import {mixin} from "../../mixin";

    export default {
        components: {
            SelectStatus
        },
        mixins: [mixin],
        props: ['status'],
        data() {
            return {
                search: '',
                show: true,
                lists: {
                    data: []
                }
            }
        },
        computed: {
            url() {
                return `/api/pregnancyprocess?status=${this.status}&search=${this.search}`;
            },
            next() {
                return `${this.lists.links.next}&status=${this.status}&search${this.search}`;
            }
        },
        created() {
            this.getData();
            this.listenEvent();
        },
        methods: {
            save(v) {
                this.axios.put(v.links.update, v.data).then(res => {
                    this.$noty.info(res.data.message);
                    this.$parent.$parent.$parent.refresh();
                })
            },
            getData() {
                if (this.status) {
                    this.axios(this.url).then(res => {
                        this.lists = res.data;
                    })
                }
            },
            loadMore() {
                if (this.lists.links.next) {
                    this.$noty.info("mengambil data dari server");
                    this.axios(this.next).then(res => {
                        if (res.data) {
                            this.$noty.info("data berhasil diambil");
                        }
                        res.data.data.forEach(v => {
                            this.lists.data.push(v);
                        });
                        this.lists.meta = res.data.meta;
                        this.lists.links = res.data.links;
                    });
                } else {
                    this.$noty.error("data sudah habis");
                }
            },
            listenEvent() {
                Echo.channel('new-born-channel')
                    .listen('.new-born-event', (res) => {
                        // this.$noty.info('Update Dashboard kelahiran');
                        this.getData();
                    });
            },
            showDetail(v) {
                var show = this.$store.state.detail;
                this.$store.commit('_detail', {
                    show: !show,
                    data: v,
                    target: '#modal-detail'
                })
            },
            showRiwayat(v) {
                var show = this.$store.state.detail;
                this.$store.commit('_riwayat', {
                    show: !show,
                    data: v,
                    target: '#modal-riwayat'
                })
            },
        }
    }
</script>
