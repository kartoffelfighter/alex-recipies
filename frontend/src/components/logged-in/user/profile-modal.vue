<template>
  <v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on }">
        <v-btn color="orange lighten-2" depressed v-on="on">
          <v-icon dark left>settings</v-icon>Account
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">{{ user.firstname }}s Account</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12 sm6 md6>
                <v-text-field label="Vorname*" required :value="user.firstname"></v-text-field>
              </v-flex>
              <v-flex xs12 sm6 md6>
                <v-text-field
                  label="Nachname*"
                  required
                  :value="user.name"
                ></v-text-field>
              </v-flex>
              <v-flex xs12>
                <v-text-field label="Email*" required :value="user.email"></v-text-field>
              </v-flex>
              <v-flex xs12>
                <v-text-field label="Passwort*" type="password" required :value="user.password"></v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
          <small>Mit * markierte Felder müssen ausgefüllt werden.</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click="dialog = false">Verwerfen</v-btn>
          <v-btn color="blue darken-1" flat @click="dialog = false">Speichern</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
export default {
  props: {
    user: Array,
  },
  data: () => ({
    dialog: false
  })
};
</script>