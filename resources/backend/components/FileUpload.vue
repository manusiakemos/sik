<template>
    <div class="image-upload-wrapper">
        <div class="my-8">
            <image-uploader
                    :preview="preview"
                    :className="['fileinput', { 'fileinput--loaded': hasImage }]"
                    capture="environment"
                    :debug="1"
                    doNotResize="gif"
                    :autoRotate="true"
                    outputFormat="verbose"
                    @input="setImage"
            >
                <label for="fileInput" slot="upload-label" class="d-block">
                    <figure class="text-center">
                        <span class="fa fa-camera fa-4x"></span>
                    </figure>
                    <span
                            class="upload-caption text-center d-block"
                    >{{ hasImage ? "Klik untuk upload foto" : "Klik untuk upload foto" }}</span>
                </label>
            </image-uploader>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["value"],
        computed: {
            image: {
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
                msg: "",
                hasImage: false,
                preview: false,
            };
        },
        methods: {
            setImage: function (output) {
                this.hasImage = true;
                this.image = output;
                this.$noty.warning("Foto berhasil dipilih");
            }
        }
    };
</script>
