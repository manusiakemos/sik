<template>
	<div class="my-editor-wrapper">
		<ckeditor :editor="editor" v-model="propModel" :config="editorConfig"></ckeditor>
	</div>
</template>

<script>
	import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
	export default {
    props:["value"],
    computed: {
			propModel: {
				get() {
					return this.value;
				},
				set(value) {
					this.$emit("input", value);
				}
			}
		},
		data() {
			return {
				editor: ClassicEditor,
				editorConfig: {
					toolbar: [
						"heading",
						"|",
						"bold",
						"italic",
						"link",
						"bulletedList",
						"numberedList",
						"blockQuote"
					]
				}
			};
		}
	};
</script>

