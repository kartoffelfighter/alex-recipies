<template>
  <v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="600px">
      <template v-slot:activator="{ on }">
        <v-btn color="orange lighten-2" depressed v-on="on">
          <v-icon dark left>settings</v-icon>Account
        </v-btn>
        <v-btn color="green lighten-2" depressed v-on="on" @click="create = true">
          <v-icon dark left>add</v-icon>Benutzer
        </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span v-if="create" class="headline">Neuen Benutzer anlegen</span>
          <span v-else class="headline">{{ user.firstname }}s Account</span>
        </v-card-title>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-flex xs12 sm6 md6>
                <v-text-field v-if="create" label="Vorname*" required ></v-text-field>
                <v-text-field v-else label="Vorname*" required :value="user.firstname"></v-text-field>
              </v-flex>
              <v-flex xs12 sm6 md6>
                <v-text-field v-if="create" label="Nachname*" required ></v-text-field>
                <v-text-field v-else label="Nachname*" required :value="user.name"></v-text-field>
              </v-flex>
              <v-flex xs12>
                <v-text-field v-if="create" label="Email*" required ></v-text-field>
                <v-text-field v-else label="Email*" required :value="user.email"></v-text-field>
              </v-flex>
              <v-flex xs12>
                <v-text-field v-if="create" label="Passwort*" type="password" required ></v-text-field>
                <v-text-field v-else label="Passwort*" type="password" required :value="user.password"></v-text-field>
              </v-flex>
            </v-layout>
          </v-container>
          <small>Mit * markierte Felder müssen ausgefüllt werden.</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" flat @click="dialog = false, create = false">Verwerfen</v-btn>
          <v-btn color="blue darken-1" flat @click="dialog = false, create = false">Speichern</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
export default {
  props: {
    create: Boolean,
    user: Array
  },
  data: () => ({
    dialog: false,
    create: false,
  }),
  methods: {
  }
};
</script>