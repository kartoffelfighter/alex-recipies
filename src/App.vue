<template>
  <v-app>
    <v-container grid-list-md class="app">
      <v-toolbar app>
        <toolbar />
      </v-toolbar>

      <v-content app>
        <router-view></router-view>
      </v-content>
    </v-container>
  </v-app>
</template>

<script>
import toolbar from "./components/navigation/toolbar.vue";
export default {
  components: {
    toolbar
  }
};
document.title = "Hallo Katja";
</script>

<style>
.app {
  width: 100%;
}
</style>
