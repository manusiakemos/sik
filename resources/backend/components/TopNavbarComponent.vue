<template>
	<div id="top-navbar-component">
		<nav class="navbar navbar-expand-lg main-navbar">
			<router-link to="/">
				<img src="/images/tabalong.png" alt="logo" width="50" class="mr-3" />
			</router-link>
			<ul class="navbar-nav navbar-right ml-auto">
				<auth-dropdown v-if="$store.state.auth.loggedIn == true"></auth-dropdown>
				<router-link v-else to="/login" class="nav-link" >LOGIN</router-link>
			</ul>
		</nav>
	</div>
</template>

<script>
	import Notification from "../components/NotificationComponent";
	import Messages from "../components/MessageComponent";
	import Search from "../components/SearchComponent";
	import AuthDropdown from "../components/AuthDropdown";
	export default {
		components: {
			Notification,
			Messages,
			Search,
			AuthDropdown
		},
		data() {
			return {
				search: "",
				show: false
			};
		},
		computed: {
			auth() {
				return this.$store.state.auth.user;
			}
		},
		methods: {
			commitSearch() {
				this.$store.commit("_search", this.search);
				this.closeSearch();
			},
			openSearch() {
				if (this.$route.path != "/") {
					this.$router.push({ path: "/" });
				}
				this.show = true;
			},
			closeSearch() {
				this.show = false;

				if ($(".section-two").length) {
					$("html, body").animate(
						{
							scrollTop: $(".section-two").offset().top
						},
						1000
					);
				}
			}
		}
	};
</script>
