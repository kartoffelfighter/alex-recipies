<template>
  <v-container text-xs-centered>
    <v-layout row wrap>
      <v-flex min-width="500px">
        <v-form ref="form" v-model="valid" lazy-validation @submit.prevent="login()">
          <v-text-field v-model="email" :rules="emailRules" label="E-mail" required></v-text-field>
          <v-text-field v-model="password" label="Passwort" :rules="passwordRules" type="password"></v-text-field>
          <v-divider></v-divider>
          <v-btn :disabled="!valid" color="success" type="submit">Anmelden</v-btn>
          <v-btn color="warning" disabled>Passwort vergessen</v-btn>
        </v-form>
      </v-flex>
    </v-layout>
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
    },
    login: function() {
      this.$store.dispatch('LOG_IN', {email: this.email, password: this.password })
      .then(() => this.$router.push('/dashboard'))
    }
  },
  computed: {
   status() {
     return this.$store.getters.STATUS
   },
   loading() {
     return this.$store.getters.LOADING
   }
  }
};
</script>