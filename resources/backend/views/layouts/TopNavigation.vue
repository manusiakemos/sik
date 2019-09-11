<template>
	<div id="top-navbar-component">
		<top-navbar-component></top-navbar-component>
		<div>
			<transition name="fade" mode="out-in">
				<router-view></router-view>
			</transition>
		</div>
	</div>
</template>

<script>
	import TopNavbarComponent from "../../components/TopNavbarComponent";
	export default {
		components: {
			TopNavbarComponent
		},
		mounted() {
			setTimeout(() => {
				document.querySelector("body").setAttribute("class", "layout-3");
				initJs();
			}, 500);
		}
	};
</script>

