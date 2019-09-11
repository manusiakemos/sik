<template>
	<div class="datepicker-wrapper">
		<date-picker input-class="form-control" value-type="format" v-model="propModel" :format="format" type="year" :lang="lang"></date-picker>
	</div>
</template>

<script>
	import DatePicker from "vue2-datepicker";

	export default {
		components: {
			DatePicker
		},
		props: ["value"],
		data() {
			return {
				format: "YYYY",
				lang: {
					days: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
					months: [
						"Jan",
						"Feb",
						"Mar",
						"Apr",
						"May",
						"Jun",
						"Jul",
						"Aug",
						"Sep",
						"Oct",
						"Nov",
						"Dec"
					],
					pickers: [
						"next 7 days",
						"next 30 days",
						"previous 7 days",
						"previous 30 days"
					],
					placeholder: {
						date: "Pilih Tahun",
						dateRange: "Pilih Date Range"
					}
				}
			};
		},
		computed: {
			propModel: {
				get() {
					return this.value.toString();
				},
				set(value) {
					this.$emit("input", value);
				}
			}
		}
	};
</script>
