<template>
	<section class="section">
		<div class="container mt-5">
			<div class="row">
				<div
					class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4"
				>
					<div class="login-brand">
						<img src="/images/tabalong.png" alt="logo" width="100" />
					</div>

					<div class="card card-primary">
						<div class="card-body">
							<div class="text-center">
								<h4 class="text-uppercase text-primary mb-4">{{$store.state.app_name}}</h4>
							</div>
							<form method="POST" autocomplete="off" action="/login" novalidate v-on:submit.prevent="submitLogin">
								<div class="form-group">
									<label for="username">Username</label>
									<input
										v-model="data.username"
										id="username"
										type="text"
										autocomplete="username"
										class="form-control"
										name="username"
										tabindex="1"
										required
										autofocus
									/>
									<small class="text-danger" v-if="this.errors.username">
										{{
										this.errors.username.join() }}
									</small>
								</div>

								<div class="form-group">
									<label for="password">Password</label>
									<input
										v-model="data.password"
										id="password"
										type="password"
										class="form-control"
										autocomplete="current-password"
										name="password"
										tabindex="2"
										required
									/>
									<small class="text-danger" v-if="this.errors.password">
										{{
										this.errors.password.join() }}
									</small>
								</div>

								<div class="form-group">
									<button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">Login</button>
								</div>
							</form>
							<div class="text-center mt-4 mb-3">
								<div class="text-job text-muted">
									<!-- <router-link to="/">Kembali Ke Halaman Awal</router-link> -->
								</div>
							</div>
						</div>
					</div>

					<!--<div class="simple-footer text-white">{{ $store.state.app_name }}</div>-->
				</div>
			</div>
		</div>
	</section>
</template>

<script>
	export default {
		data() {
			return {
				data: {
					username: "",
					password: "",
					remember: ""
				},
				errors: ""
			};
		},
		methods: {
			submitLogin() {
				this.errors = "";
				this.$http
					.post("/api/login", this.data)
					.then(res => {
						// console.log(res);
						if (res.status == 200) {
							var d = res.data.data;
							if (d) {
								if (d.api_token) {
									this.$noty.warning("Login Success...");
									this.$store.commit("_loggedIn", true);
									this.$store.commit("_profile", d);

									this.$http.defaults.headers.common[
										"Authorization"
									] = `Bearer ${d.api_token}`;
									$.ajaxSetup({
										headers: { "Authorization": `Bearer ${d.api_token}` }
									});

									if (d.role == "voter-admin") {
										this.$router.push({ path: "/enter-token" });
									} else {
										this.$router.push({ path: "/home" });
									}
								}else{
                                    this.$noty.error("Username atau password salah");
                                }
							}
						}
					})
					.catch(error => {
						this.$noty.error("Username atau password salah");
						// this.errors = error.response.errors;
					});
			}
		}
	};
</script>
