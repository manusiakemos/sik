<template>
    <select autofocus v-model="value" @input="$emit('input', $event.target.value)" class="form-control form-control-sm w-50" style="border: 2px solid gray">
        <option value="">Pilih Status</option>
        <option v-for="option in options" :value="option.value">{{ option.text }}</option>
    </select>
</template>

<script>
    export default {
        props:['value'],
        data () {
            return {
                options: [],
            };
        },
        created(){
            this.axios.post('/api/select-status').then(res=>{
                this.options = res.data;
            })
        }
    }
</script>
