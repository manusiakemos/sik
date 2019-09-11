<template>
    <div class="wrap-component">
        <model-select :options="arrayData" v-model="propModel" placeholder="Cari dan pilih kategori..."></model-select>
    </div>
</template>

<script>
    import { ModelSelect } from "vue-search-select";
    export default {
        components: {
            ModelSelect
        },
        props: ["value"],
        created() {
            this.getData();
        },
        data() {
            return {
                arrayData: []
            };
        },
        computed: {
            propModel: {
                get() {
                    return this.value;
                },
                set(value) {
                    this.$emit("input", value);
                }
            }
        },
        methods: {
            getData() {
                this.$http.get("/api/berita/list").then(res => {
                    this.arrayData = res.data;
                });
            }
        }
    };
</script>
