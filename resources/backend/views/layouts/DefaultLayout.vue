<template>
    <div id="top-navbar-component">
        <navbar-component></navbar-component>
        <div>
            <transition name="fade" mode="out-in">
                <router-view></router-view>
            </transition>
        </div>
    </div>
</template>
<script>
    import NavbarComponent from "../../components/NavbarComponent";

    export default {
        components: {
            NavbarComponent
        },
        created() {
            if (this.$store.state.auth.loggedIn) {
                this.$http.defaults.headers.common["Authorization"] = `Bearer ${
                    this.$store.state.auth.user.api_token
                    }`;
            }
        },
        mounted() {
            setTimeout(() => {
                document.querySelector("body").setAttribute("class", "layout-1");
                initJs();
            }, 500);
        }
    };
</script>
