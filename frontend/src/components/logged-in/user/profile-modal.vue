<template>
  <v-layout row justify-center>
    <v-dialog v-model="dialog" persistent max-width="600px">
      <v-card>
        <v-form @submit.prevent="register()">
          <v-card-title>
            <span v-if="create" class="headline">Neuen Benutzer anlegen</span>
            <span v-else class="headline">{{ user.firstname }}s Account</span>
          </v-card-title>
          <v-card-text>
            <v-container grid-list-md>
              <v-layout wrap>
                <v-flex xs12 sm6 md6>
                  <v-text-field v-model="firstname" v-if="create" label="Vorname*" required></v-text-field>
                  <v-text-field v-else label="Vorname*" required :value="user.firstname"></v-text-field>
                </v-flex>
                <v-flex xs12 sm6 md6>
                  <v-text-field v-model="lastname" v-if="create" label="Nachname*" required></v-text-field>
                  <v-text-field v-else label="Nachname*" required :value="user.name"></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-text-field v-model="email" v-if="create" label="Email*" required></v-text-field>
                  <v-text-field v-else label="Email*" required :value="user.email"></v-text-field>
                </v-flex>
                <v-flex xs12>
                  <v-text-field
                    v-model="password"
                    v-if="create"
                    label="Passwort*"
                    type="password"
                    required
                  ></v-text-field>
                  <v-text-field v-else label="Passwort*" type="password" required></v-text-field>
                </v-flex>
              </v-layout>
            </v-container>
            <small>Mit * markierte Felder müssen ausgefüllt werden.</small>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" flat @click="dialog = false">Verwerfen</v-btn>
            <v-btn type="submit" color="blue darken-1" flat>Speichern</v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
export default {
  props: {
    create: Boolean,
  },
  data: () => ({
    registerModal: false,
    updateModal: true,
    dialog: true,
  }),
  computed: {
    token() {
      return this.$store.getters.TOKEN;
    }
  },
  methods: {
    submit() {
      if(this.registerModal){
        this.register();
      }
      if(this.profileModal){
        this.update();
      }
    },
    register() {
      this.$store.dispatch("REGISTER", {
        token: this.token,
        firstname: this.firstname,
        lastname: this.lastname,
        email: this.email,
        password: this.password
      });
    }
  },
  mounted: function() {
    this.$store.watch(
      state => state.userModal,
      () => {
        this.registerModal = this.$store.getters.ISREGISTERMODAL;
        this.profileModal = this.$store.getters.ISPROFILEMODAL;
        this.dialog = true;
        return
      }
    );
  }
};
</script>