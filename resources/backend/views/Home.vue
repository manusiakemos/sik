<template>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ title }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <a href="#">{{ title }}</a>
                    </div>
                </div>
            </div>
            <!-- if super admin -->
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Dashboard</h4>
                    </div>
                    <div class="card-body">
                        <pre>{{lists}}</pre>
                    </div>
                </div>
            </div>
            <!-- end if super admin -->
        </section>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                title: "Dashboard",
                result: "",
                data: "",
                lists: [],
                show: false,
                canvas_base64: "",
                year_month: "",
                my_chart_data: ""
            };
        },
        computed: {
            auth_user() {
                return this.$store.state.auth.user;
            }
        },
        created() {
            this.getData();
        },
        mounted() {
            this.listenPusher();
        },
        methods: {
            print(selector) {
                let canvas = document.getElementById("bar-chart");
                this.canvas_base64 = canvas.toDataURL("image/png");
                this.$nextTick(() => {
                    this.$htmlToPaper(selector);
                })
            },
            getData() {
                this.$http.get('/api/pregnancyprocess').then(res => {
                    if (res.data) {
                        this.show = true
                    }
                    this.lists = res.data;
                })
            },
            listenPusher() {
                Echo.channel('new-born-channel')
                    .listen('.new-born-event', (e) => {
                        this.$swal('Perhatian', 'Ada kelahiran baru');
                        // this.getData();
                        var url = e.route;

                        this.$http.get(url).then(res => {
                            this.data = res.data;
                            var f = _.find(this.lists, res.data);
                            if(!f){
                                this.lists.push(res.data);
                            }
                        })
                    });
            },
        }
    };
</script>

