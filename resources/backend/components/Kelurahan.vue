<template>
	<div class="wrap-component">
		<model-select :options="kelurahan" v-model="propModel" placeholder="Cari Kelurahan"></model-select>
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
			this.getKelurahan();
		},
		data() {
			return {
				kelurahan: []
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
			getKelurahan() {
				this.$http.get("/api/kelurahan").then(res => {
					this.kelurahan = res.data;
				});
			}
		}
	};
</script>
