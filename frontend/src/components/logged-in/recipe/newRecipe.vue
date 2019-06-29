<template>
  <v-layout row justify-center>
    <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
      <template v-slot:activator="{ on }">
        <v-btn v-if="!edit" color="red lighten-2" depressed round v-on="on">
          <v-icon dark left>add</v-icon>Neu
        </v-btn>
        <v-btn v-else v-on="on" depressed small light>
          <v-icon dark left>settings</v-icon>Bearbeiten
        </v-btn>
      </template>
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>Neues Rezept</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn dark flat @click="dialog = false">Speichern</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <recipe edit/>
      </v-card>
    </v-dialog>
  </v-layout>
</template>


<script>
import recipe from "@/components/logged-in/recipe/recipe.vue";
export default {
  components: {
    recipe
  },
  props: {
    edit: Boolean
  },
  data() {
    return {
      dialog: false,
      notifications: false,
      sound: true,
      widgets: false
    };
  }
};
</script>