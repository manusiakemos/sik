<template>
	<div id="navbar-component">
		<div class="navbar-bg"></div>
		<nav class="navbar navbar-expand-lg main-navbar">
			<div class="mr-auto">
				<ul class="navbar-nav mr-3">
					<li>
						<a href="#" data-toggle="sidebar" class="nav-link nav-link-lg" id="sidebar-toggler">
							<i class="fas fa-bars"></i>
						</a>
					</li>
				</ul>
			</div>
			<ul class="navbar-nav navbar-right">
				<!--<messages v-if="$store.state.auth.loggedIn == true"></messages>-->
				<!-- <notification v-if="$store.state.auth.loggedIn == true"></notification> -->
				<auth-dropdown v-if="$store.state.auth.loggedIn == true" ref="auth_dropdown"></auth-dropdown>
				<li v-if="$store.state.auth.loggedIn == false">
					<router-link class="nav-link nav-link-user" to="/login">LOGIN</router-link>
				</li>
			</ul>
		</nav>
		<sidebar></sidebar>
	</div>
</template>

<script>
	import Notification from "../components/NotificationComponent";
	import Messages from "../components/MessageComponent";
	import Search from "../components/SearchComponent";
	import AuthDropdown from "../components/AuthDropdown";
	import Sidebar from "../components/Sidebar";
	export default {
		components: {
			Notification,
			Messages,
			Search,
			AuthDropdown,
			Sidebar
		}
	};
</script>

