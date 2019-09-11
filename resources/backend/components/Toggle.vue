<template>
	<div class="wrap-component">
		<toggle-button v-model="propModel" :labels="labels" :height="heigth" :width="width"/>
	</div>
</template>

<script>
    import {ToggleButton} from 'vue-js-toggle-button'
    export default {
		components: {
			ToggleButton
		},
		props: ["value", "heigth", "width", "labels"],
		computed: {
			propModel: {
				get() {
					return this.value == '1' ? true : false;
				},
				set(value) {
					this.$emit("input", value);
				}
			}
		}
	};
</script>
