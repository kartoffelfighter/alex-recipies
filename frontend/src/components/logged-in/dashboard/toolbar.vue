<template>
  <v-container grid-list-xs>
    <v-card color="blue lighten-2" dark dense flat>
      <v-layout row wrap>
        <v-flex xs8>
          <newRecipeModal />
        </v-flex>
        <v-flex xs4>
          <v-btn color="orange lighten-2" depressed @click.stop="settingsModal()">
            <v-icon dark left>settings</v-icon>Account
          </v-btn>
          <v-btn color="green lighten-2" depressed @click.stop="registerModal()">
            <v-icon dark left>add</v-icon>Benutzer
          </v-btn>
        </v-flex>
      </v-layout>
       <profileModal />
    </v-card>
  </v-container>
</template>

<script>
import profileModal from "@/components/logged-in/user/profile-modal.vue";
import newRecipeModal from "@/components/logged-in/recipe/newRecipe.vue";
export default {
  components: {
    profileModal,
    newRecipeModal
  },
  methods: {
    registerModal() {
      this.$store.commit('TOGGLE_NEWUSERMODAL');
    },
    settingsModal() {
      this.$store.commit('TOGGLE_PROFILEMODAL');
    }
  }
};
</script>
