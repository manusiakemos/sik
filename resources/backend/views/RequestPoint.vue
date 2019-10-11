<template>
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ title }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">
                        <router-link to="home">{{title}}</router-link>
                    </div>
                    <div class="breadcrumb-item">Datatables</div>
                </div>
            </div>

            <div class="section-body">

            </div>
        </section>
    </div>
</template>

<script>
    import {mixin} from "../mixin";

    export default {
        mixins: [mixin],
        created() {
            this.data2 = this.data;
        },
        data() {
            return {
                action: "store",
                title: "Point",
                data: '',
                data2: '',
                errors: [],
                selectData: {}
            };
        },
        mounted() {
            this.initActionDt();
        },
        methods: {
            initActionDt() {

            },
            refresh() {
                this.$refs.dt.refresh();
            },
        }
    };
</script>

