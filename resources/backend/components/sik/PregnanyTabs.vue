<template>
    <div class="container p-3">
        <vue-tabs activeTabColor="#F9DA7F" activeTextColor="#535B61" type="tabs" :centered="false" v-if="role == 'capil'">
            <v-tab title="Born">
                <born status="born" ref="bornRef"></born>
            </v-tab>

            <v-tab title="Done">
                <born status="done" ref="doneRef"></born>
            </v-tab>
        </vue-tabs>
        <vue-tabs activeTabColor="#F9DA7F" activeTextColor="#535B61" type="tabs" :centered="false" v-else>
            <v-tab title="Done">
                <born status="done" ref="doneRef2"></born>
            </v-tab>

            <v-tab title="Send">
                <born status="send" ref="sendRef"></born>
            </v-tab>
        </vue-tabs>
    </div>
</template>

<script>
    import Born from "./Born";

    export default {
        components: {
            Born
        },
        computed: {
            role() {
                return this.$store.state.auth.user.role;
            }
        },
        methods: {
            refresh() {
                var role = this.role;
                if (role == 'capil') {
                    this.refreshBorn();
                    this.refreshDone();
                } else {
                    this.refreshDone2();
                    this.refreshSend();
                }
            },
            refreshBorn() {
                this.$refs.bornRef.getData();
            },
            refreshDone() {
                this.$refs.doneRef.getData();
            },
            refreshDone2() {
                this.$refs.doneRef2.getData();
            },
            refreshSend() {
                this.$refs.sendRef.getData();
            }
        }
    }
</script>

<style>
    .title.title_center{
        color: white;
    }
    .nav-tabs-navigation{
        background: #55BCCA;
        padding: 10px;
    }
</style>
