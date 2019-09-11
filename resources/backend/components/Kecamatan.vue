<template>
	<div class="wrap-component">
		<model-select :options="optionsData" v-model="propModel" placeholder="Cari Kecamatan"></model-select>
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
				optionsData: []
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
				this.$http.get("/api/kecamatan").then(res => {
					this.optionsData = res.data;
				});
			}
		}
	};
</script>
