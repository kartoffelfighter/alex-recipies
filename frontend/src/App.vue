<template>
  <v-app >
    <v-container grid-list-md class="app">
      <v-toolbar app>
        <toolbar />
      </v-toolbar>
      <v-content app>
        <router-view></router-view>
      </v-content>
      <notification />
    </v-container>
  </v-app>
</template>

<script>
import toolbar from "./components/navigation/toolbar.vue";
import notification from "./components/forms/notification.vue";
export default {
  components: {
    toolbar,
    notification
  }
};
document.title = "Hallo Katja";
</script>

<style>
.app {
  width: 100%;
}
</style>
