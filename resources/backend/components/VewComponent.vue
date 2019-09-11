<template>
	<div id="login-btn-wrap" class="text-center">
		<button v-on:click="AuthProvider('facebook')" class="btn btn-info">auth facebook</button>
	</div>
</template>

<script>
	export default {
		data() {
			return {};
		},
		methods: {
			AuthProvider(provider) {
				var self = this;

				this.$auth
					.authenticate(provider)
					.then(response => {
						self.SocialLogin(provider, response);
					})
					.catch(err => {
						console.log({ err: err });
					});
			},

			SocialLogin(provider, response) {
				this.$http
					.post("/sociallogin/" + provider, response)
					.then(response => {
						console.log(response.data);
					})
					.catch(err => {
						console.log({ err: err });
					});
			}
		}
	};
</script>
