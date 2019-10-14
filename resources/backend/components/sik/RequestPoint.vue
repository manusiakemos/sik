<template>
    <!--<pre>{{lists}}</pre>-->
    <div id="request-point">
        <div class="row" v-if="lists && lists.length > 0">
            <div class="col-md-4" v-for="v in lists">
                <div class="card shadow-sm border">
                    <div class="card-header">
                        <h4 class="text-primary">
                            {{v.data.bidan.bidan_nama}}
                        </h4>
                        <div class="card-header-action ml-auto">
                            <button class="btn btn-primary" @click="updateStatus('cancel', v)">Tolak</button>
                            <button class="btn btn-danger" @click="updateStatus('verify', v)">Terima</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4>{{v.data.reward_point}} POINT</h4>
                    </div>
                </div>
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
        data() {
            return {
                lists: ''
            }
        },
        created() {
            this.getLists();
            this.listenEcho()
        },
        methods: {
            getLists() {
                this.axios.get('/api/reward').then(res => {
                    this.lists = res.data;
                })
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
                Echo.channel('request-point-channel')
                    .listen('.request-point-event', (res) => {
                        this.$noty.info('Ada permintaan tukar poin');
                        this.getLists();
                    });
            },
        },
    }
</script>
