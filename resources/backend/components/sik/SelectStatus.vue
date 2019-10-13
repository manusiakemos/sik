<template>
    <el-select v-model="propModel" placeholder="Pilih Salah Satu" class="w-100" popper-class="w-sm-100">
        <el-option
                v-for="option in options"
                :key="option.value"
                :label="option.text"
                :value="option.value">
        </el-option>
    </el-select>
</template>

<script>
    export default {
        props:['value'],
        data () {
            return {
                options: [],
                myValue:'',
            };
        },
        computed:{
            propModel:{
                get: function () {
                    return this.value;
                },
                // setter
                set: function (newValue) {
                    this.$emit("input", newValue);
                }
            }
        },
        created(){
            this.axios.post('/api/select-status').then(res=>{
                this.options = res.data;
            })
        }
    }
</script>
