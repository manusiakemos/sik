<template>
  <div class="main-sidebar">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <router-link active-class="active" to="/home">{{ app.name }}</router-link>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <router-link active-class="active" to="/home">{{ app.name.substr(0,2) }}</router-link>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li>
          <router-link active-class="active" class="nav-link" to="home">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
          </router-link>
        </li>
        <li class="menu-header">Master</li>
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
            <i class="fas fa-columns"></i>
            <span>Master</span>
          </a>
          <ul class="dropdown-menu">
            <li>
              <router-link active-class="active" class="nav-link" to="/foo">Go To Foo</router-link>
            </li>
            <li>
              <router-link active-class="active" class="nav-link" to="/bar">Go To Bar</router-link>
            </li>
          </ul>
        </li>
        <li class="menu-header">Transaksi</li>
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
            <i class="fa fa-exchange-alt"></i>
            <span>Transaksi</span>
          </a>
          <ul class="dropdown-menu">
            <li>
              <router-link active-class="active" class="nav-link" to="/foo">Go To Foo</router-link>
            </li>
            <li>
              <router-link active-class="active" class="nav-link" to="/bar">Go To Bar</router-link>
            </li>
          </ul>
        </li>
        <li class="menu-header" v-show="role == 1">Lainnya</li>
        <li class="dropdown" v-show="role == 1">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
            <i class="fa fa-cogs"></i>
            <span>Lainnya</span>
          </a>
          <ul class="dropdown-menu">
            <li>
              <router-link active-class="active" class="nav-link" to="/user">Manajemen User</router-link>
            </li>
            <!-- <li>
              <router-link active-class="active" class="nav-link" to="/user2">Manajemen User2</router-link>
            </li>-->
          </ul>
        </li>
      </ul>
      <div class="p-3 mt-4 mb-4 hide-sidebar-mini">
        <a
          href="/logout"
          class="btn btn-primary btn-lg btn-icon-split btn-block logout"
          style="position:relative; bottom: 10px; width:80%"
        >
          <i class="fas fa-sign-out-alt"></i>
          <div>Logout</div>
        </a>
      </div>
    </aside>
  </div>
</template>

<script>
export default {
  computed: {
    app() {
      return store.state.app;
    },
    role() {
      return store.state.auth.role;
    }
  }
};
</script>

