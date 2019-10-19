<template>
    <!--<pre>{{lists}}</pre>-->
    <div :id="id">
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-3">
                    <el-input placeholder="filter data"
                              v-model="search" @change="getLists">
                        <el-button slot="append" icon="el-icon-search"></el-button>
                    </el-input>
                </div>
            </div>
        </div>
        <div class="row" v-if="lists.data && lists.data.length > 0">
            <div class="col-md-4" v-for="v in lists.data">
                <div class="card shadow-sm border">
                    <div class="card-header">
                        <h4 class="text-primary">
                            {{v.data.bidan.bidan_nama}}
                        </h4>
                        <div class="card-header-action ml-auto" v-if="id=='request'">
                            <button class="btn btn-primary" @click="updateStatus('verify', v)">Terima</button>
                            <button class="btn btn-danger" @click="updateStatus('cancel', v)">Tolak</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4>{{v.data.reward_point}} POINT</h4>
                        <div v-html="v.data.bidan.bidan_alamat ? v.data.bidan.bidan_alamat : 'Alamat bidan belum diinput'"></div>
                        <p>{{v.data.bidan.bidan_telp}}</p>
                        <i class="font-weight-600">{{v.tanggal_reward}}</i>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <button class="btn btn-outline-dark btn-block" @click="loadMore">Muat Lebih Banyak</button>
            </div>
        </div>

        <div class="row" v-else>
            <div class="col-12">
                <h4 class="text-center">Tidak Ada Permintaan Tukar Poin</h4>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['id'],
        data() {
            return {
                search:'',
                lists: '',
                tempLists:'',
            }
        },
        created() {
            this.getLists();
            this.listenEcho()
        },
        methods: {
            getLists() {
                this.axios.get(`/api/reward/status/${this.id}?search=${this.search}`).then(res => {
                    this.lists = res.data;
                })
            },
            loadMore() {
                var me = this;
                if (this.lists.links.next) {
                    this.$noty.info("mengambil data dari server");
                    this.axios(this.lists.links.next).then(res => {
                        if (res.data) {
                            this.$noty.info("data berhasil diambil");
                        }
                        res.data.data.forEach(v => {
                            this.lists.data.push(v);
                        });
                        me.lists.meta = res.data.meta;
                        me.lists.links = res.data.links;
                    });
                } else {
                    this.$noty.error("data sudah habis");
                }
            },
            updateStatus(status, value) {
                this.$swal({
                    title: "Apakah Kamu Yakin?",
                    type: "warning",
                    confirmButtonText: "Ya",
                    showCancelButton: true,
                    confirmButtonColor: this.$store.state.primary_color,
                    cancelButtonText: "Tidak"
                }).then(result => {
                    if (result.value) {
                        this.axios.put(value.links.update, {
                            'reward_status': status
                        }).then(res => {
                            this.$noty.info(res.data.message);
                            this.getLists();
                        })
                    }
                });
            },
            listenEcho() {
                if (this.id == 'request') {
                    Echo.channel('request-point-channel')
                        .listen('.request-point-event', res => {
                            this.$noty.info('Ada permintaan tukar poin');
                            this.getLists();
                        });
                }

                Echo.channel('refresh-point-channel')
                    .listen('.refresh-point-event', res => {
                        this.getLists();
                    });
            },
        },
    }
</script>
