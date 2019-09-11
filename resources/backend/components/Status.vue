<template>
	<div class="wrap-status">
		<select v-model="selected" @input="$emit('input', $event.target.value)" class="form-control">
			<option :value="null">Pilih Status</option>
			<option v-for="option in options" :value="option">{{ option }}</option>
		</select>
	</div>
</template>

<script>
	export default {
		props: {
			options: {
				// type: Array,
				default: () => {
						return ["aktif", "tidak aktif"]
					}
			},
			value:{
				// type: String,
				default: null
			}
		},
		watch: {
			value(newValue, oldValue) {
				this.selected = newValue;
			}
		},
		data() {
			return {
				// options: optionProps,
				selected: this.value
			};
		}
	};
</script>
