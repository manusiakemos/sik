<template>
	<select v-model="value" @input="$emit('input', $event.target.value)" class="form-control">
		<option :value="null">Pilih Jenis Kelamin</option>
		<option v-for="option in options" :value="option.value">{{ option.text }}</option>
	</select>
</template>

<script>
	export default {
		props:["value"],
		data() {
			return {
				options: [
					{ value: "L", text: "Laki-laki" },
					{ value: "P", text: "Perempuan" }
				]
			};
		}
	};
</script>
