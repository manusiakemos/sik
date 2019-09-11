<template>
    <div class="input-text-wrapper">
        <label class="text-capitalize">{{label}}</label>
        <input type="text" class="form-control" v-model="propModel"/>
        <small class="text-danger" v-if="error">{{ error.join() }}</small>
    </div>
</template>

<script>
    export default {
        props: ["value", "label", "error"],
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
        }
    };
</script>
