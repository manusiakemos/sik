<template>
	<div id="table" class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th v-for="column in columns">{{ column }}</th>
				</tr>
			</thead>
      <tbody>
        <tr v-for="(v,i) in data.data">
          <td>{{ columns.title[i] }}</td>
        </tr>
      </tbody>
		</table>
	</div>
</template>

<script>
	export default {
		props: {
			columns: {
				type: Array,
				default: ""
			},
			ajaxUrl: {
				type: String,
				default: ""
			}
		},
		data() {
			return {
				data: ""
			};
		},
		created() {
			this.$http.get(this.ajaxUrl).then(res => {
				this.data = res.data;
			});
		}
	};
</script>

