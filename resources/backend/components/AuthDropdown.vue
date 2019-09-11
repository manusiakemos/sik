<template>
	<li class="dropdown">
		<a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
			<img alt="image" :src="auth.avatar" class="rounded-circle mr-1" />
			<div class="d-sm-none d-lg-inline-block">{{auth.name}}</div>
		</a>
		<div class="dropdown-menu dropdown-menu-right">
			<div class="dropdown-title">{{ auth.username }}</div>
			<div v-if="auth.role != 'user'">
				 <router-link to="/profile" class="dropdown-item has-icon">
					<i class="fas fa-user"></i> Profile
				</router-link>
				<router-link to="/setting" class="dropdown-item has-icon">
					<i class="fas fa-cog"></i> Settings
				</router-link>
				 <div class="dropdown-divider"></div>
			</div>
			<a href="#" class="dropdown-item has-icon text-danger" v-on:click.prevent="logout">
				<i class="fas fa-sign-out-alt"></i> Logout
			</a>
		</div>
	</li>
</template>

<script>
	export default {
		computed: {
			auth() {
				return this.$store.state.auth.user;
			}
		},
		methods: {
			logout() {
				this.$swal({
					title: "Logout Sekarang?",
					type: "warning",
					confirmButtonText: "Ya",
					confirmButtonColor: this.$store.state.primary_color,
					showCancelButton: true,
					cancelButtonText: "Tidak"
				}).then(result => {
					if (result.value) {
						this.$store.commit("_token", "");
						this.$store.commit("_profile", "");
						this.$http.defaults.headers.common["Authorization"] = "";
						this.$store.commit("_loggedIn", false);
						this.$noty.warning("logout");
						this.$router.push({ path: "/" });
					}
				});
			}
		}
	};
</script>


