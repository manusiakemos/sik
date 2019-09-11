<template>
	<ul class="pagination" role="navigation">
		<li class="page-item">
			<span class="page-link" v-on:click="prev($event)">Prev</span>
		</li>
		<li class="page-item">
			<span class="page-link" v-on:click="next($event)">Next</span>
		</li>
	</ul>
</template>

<script>
	export default {
		props: ["meta", "links"],
		methods: {
			prev(event) {
				this.$emit("clicked", this.links.prev);
			},
			next(event) {
				this.$emit("clicked", this.links.next);
			}
		}
	};
</script>

