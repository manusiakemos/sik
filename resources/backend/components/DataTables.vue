<template>
	<table class="table" :id="selector">
		<thead>
			<tr>
				<th v-for="(v, i) in configDt.columns" :key="i" class="text-dark-all">{{ v.title }}</th>
			</tr>
		</thead>
		<slot></slot>
	</table>
</template>


<script>
	export default {
		props: ["selector", "url", "columns"],
		data() {
			return {
				dataTablesVue: "",
				configDt: {
					ajax: {
						// url: "/api/pemilih"
						url: this.url
					},
					processing: true,
					serverSide: true,
					responsive: true,
					columns: this.columns
				}
			};
		},
		mounted() {
			this.initDt();
		},
		beforeDestroy() {
			this.dataTablesVue.clear().destroy();
		},
		methods: {
			initDt() {
				var me = this;
				me.dataTablesVue = $(document)
					.find(`#${me.selector}`)
					.DataTable(me.configDt);
			},
			refresh() {
				var me = this;
				me.$noty.warning("refresh datatables");
				me.dataTablesVue.ajax.reload();
			}
		}
	};
</script>
