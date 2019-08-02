<template>
  <v-container text-xs-centered>
    <v-layout row wrap>
      <v-flex min-width="500px">
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-text-field v-model="email" :rules="emailRules" label="E-mail" required></v-text-field>
          <v-text-field v-model="password" label="Passwort" value :rules="passwordRules" type="password"></v-text-field>
          <v-divider></v-divider>

          <v-btn :disabled="!valid" color="success" @click="validate">Anmelden</v-btn>
          <v-btn color="warning" disabled>Passwort vergessen</v-btn>
          <v-btn color="warning"  @click="storeTest()">Passwort vergessen</v-btn>
        </v-form>
      </v-flex>
    </v-layout>
    <v-snackbar
      v-model="snackbar"
      color="green lighten-2"
      top
    >
      Login erfolgreich
      <v-btn color="pink" flat @click="snackbar = false">Close</v-btn>
    </v-snackbar>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    valid: false,
    password: "",
    passwordRules: [v => !!v || "Du musst ein Password eintragen"],
    email: "",
    emailRules: [
      v => !!v || "Du musst eine Email angeben",
      v => /.+@.+/.test(v) || "Das sieht aber nicht nach einer Email aus"
    ],
    checkbox: true,
    snackbar: false
  }),

  methods: {
    validate() {
      if (this.$refs.form.validate()) {
      //  console.log(this.currentUser());
      }
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
    storeTest(){
     // console.log(this.currentUser);
    }
  },
  computed: {
    currentUser(){
      return this.$store.state.currentUser['jwt'];
    }
  }
};
</script>