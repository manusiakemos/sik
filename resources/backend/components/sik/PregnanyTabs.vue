<template>
    <div class="container">
        <el-tabs v-model="activeName" @tab-click="handleClick" v-if="role == 'kominfo'">
            <el-tab-pane label="Diproses" name="first">
                <born status="done" ref="doneRef2"></born>
            </el-tab-pane>
            <el-tab-pane label="Dikirim" name="second">
                <born status="send" ref="sendRef"></born>
            </el-tab-pane>
        </el-tabs>
        <el-tabs v-model="activeName" @tab-click="handleClick" v-else>
            <el-tab-pane label="Melahirkan" name="first">
                <born status="born" ref="bornRef"></born>
            </el-tab-pane>
            <el-tab-pane label="Diproses" name="second">
                <born status="done" ref="doneRef"></born>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>
<script>
    import Born from "./Born";

    export default {
        components: {
            Born
        },
        data() {
            return {
                activeName: 'first'
            };
        },
        computed: {
            role() {
                return this.$store.state.auth.user.role;
            }
        },
        methods: {
            refresh() {
                var role = this.role;
                /*if (role == 'capil') {
                    this.refreshBorn();
                    this.refreshDone();
                } else {
                    this.refreshDone2();
                    this.refreshSend();
                }*/
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
            },
            handleClick(tab, event) {
                console.log(tab, event);
            },
        }
    }
</script>
