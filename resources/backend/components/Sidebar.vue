<template>
    <div class="main-sidebar">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <router-link to="/" class="text-dark" id="app-name-text">{{ app_name }}</router-link>
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
                <router-link to="/" class="text-dark">
                    {{ app_name.substring(0,3) }}
                </router-link>
            </div>
            <ul class="sidebar-menu">
                <li class="menu-header">{{user.role}}</li>
                <li class="nav-item">
                    <router-link to="/home" class="nav-link">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </router-link>

                   <!-- <router-link to="/point" class="nav-link">
                        <i class="fas fa-star"></i>
                        <span>Point</span>
                    </router-link>-->
                </li>
                <li class="menu-header">Master</li>

                <li class="nav-item" v-if="user.role == 'kominfo'">
                    <router-link to="/puskesmas" class="nav-link">
                        <i class="fas fa-hospital-alt"></i>
                        <span>Puskesmas</span>
                    </router-link>
                </li>

                <li class="nav-item" v-if="user.role == 'kominfo'">
                    <router-link to="/bidan" class="nav-link">
                        <i class="fas fa-medkit"></i>
                        <span>Bidan</span>
                    </router-link>
                </li>

               <!-- <li class="nav-item" v-if="user.role == 'kominfo'">
                    <router-link to="/reward" class="nav-link">
                        <i class="fas fa-star"></i>
                        <span>Reward</span>
                    </router-link>
                </li>-->

                <li class="nav-item" v-if="user.role == 'kominfo'">
                    <router-link to="/user" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>User</span>
                    </router-link>
                </li>

                <li class="menu-header">Lainnya</li>

                <li class="nav-item">
                    <router-link to="/profile" class="nav-link">
                        <i class="fas fa-user-alt"></i>
                        <span>Profile</span>
                    </router-link>
                </li>


                <li class="nav-item">
                    <router-link to="/setting" class="nav-link">
                        <i class="fas fa-tired"></i>
                        <span>Setting</span>
                    </router-link>
                </li>

            </ul>

            <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                <a
                        href="#"
                        class="btn btn-primary btn-lg btn-block btn-icon-split"
                        v-on:click.prevent="logout()"
                >
                    <i class="fa fa-sign-out"></i>Logout
                </a>
            </div>
        </aside>
    </div>
</template>

<script>
    export default {
        computed: {
            app_name() {
                return this.$store.state.app_name;
            },
            user() {
                return this.$store.state.auth.user;
            }
        },
        methods: {
            logout: function () {
                this.$parent.$refs.auth_dropdown.logout();
            }
        }
    };
</script>

