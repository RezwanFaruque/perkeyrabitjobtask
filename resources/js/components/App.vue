<template>
  <div class="main">
    <component :is="layout">
      <router-view></router-view>
    </component>
  </div>
</template>

<script>

import NavbarComponent from './NavbarComponent.vue';

export default {
  name: "App",
  components: {
    NavbarComponent,
  },

  computed: {
    // return dynamic layout
    layout() {
      return this.$route.meta.layout;
    },
  },
};
</script>

<style>
</style>
