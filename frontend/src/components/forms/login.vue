<template>
  <v-container text-xs-centered>
    <v-layout row wrap>
      <v-flex min-width="500px">
        <v-form ref="form" v-model="valid" lazy-validation>
          <v-text-field v-model="email" :rules="emailRules" label="E-mail" required></v-text-field>
          <v-text-field
              name="password"
              label="Passwort"
              value=""
              :rules="passwordRules"
              type="password"
          ></v-text-field>

          
          <v-checkbox
            v-model="checkbox"
            
            label="Angemeldet bleiben"
          ></v-checkbox>
            <v-divider></v-divider>
            
          <v-btn :disabled="!valid" color="success" @click="validate">Anmelden</v-btn>
          <v-btn color="warning">Passwort vergessen</v-btn>
          
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
    passwordRules: [
      v => !!v || "Du musst ein Password eintragen"
    ],
    email: "",
    emailRules: [
      v => !!v || "Du musst eine Email angeben",
      v => /.+@.+/.test(v) || "Das sieht nicht nach einer Email aus"
    ],
    checkbox: true
  }),

  methods: {
    validate() {
      if (this.$refs.form.validate()) {
        this.snackbar = true;
      }
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    }
  }
};
</script>