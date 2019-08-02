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
        <v-system-bar window dark>
          <v-spacer></v-spacer>
          Neues Rezept anlegen
          <v-spacer></v-spacer>
          <v-btn icon @click="save()">
            <v-icon>save</v-icon>
          </v-btn>
          <v-btn icon @click="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>
        </v-system-bar>
        <recipe edit dialog />
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
  },
  methods: {
    save() {
      this.dialog = false;
    }
  }
};
</script>