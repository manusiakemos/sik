<template>
  <div id="app">
    <navbar></navbar>
    <sidebar></sidebar>
    <transition name="fade" mode="out-in">
      <router-view></router-view>
    </transition>
  </div>
</template>
<script>
export default {
    mounted () {
      document.querySelector("body").class = "layout-1";
      kemos();
    },
}
</script>
