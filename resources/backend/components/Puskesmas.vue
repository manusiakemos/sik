<template>
	<div class="wrap-component">
		<model-select :options="lists" v-model="propModel" placeholder="Cari Puskesmas"></model-select>
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
				lists: []
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
				this.$http.get("/api/puskesmas-list").then(res => {
					this.lists = res.data;
				});
			}
		}
	};
</script>
