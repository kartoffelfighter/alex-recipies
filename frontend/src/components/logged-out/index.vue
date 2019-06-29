<template>
  <v-container grid-list-md>
    <v-layout row wrap>
      <v-spacer></v-spacer>
      <v-flex md12 xs12 lg4>
        <v-card>
          <v-card-title class="headline grey lighten-2" primary-title>
            <h3>Anmelden</h3>
          </v-card-title>
          <v-card-text>
            <login/>
          </v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
    <v-footer app>
      <v-spacer></v-spacer>
      <v-flex lg2 md2>
        <a :to="cookies">Cookies</a> -
        <a :to="privacy">Datenschutz</a> -
        <a :to="imprint">Impressum</a>
      </v-flex>
      <v-spacer></v-spacer>
    </v-footer>
  </v-container>
</template>


<script>
import login from "@/components/forms/login.vue";
export default {
  components: {
    login
  }
};
</script>
