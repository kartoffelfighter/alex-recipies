<template>
  <v-container grid-list-xs>
    <v-card color="blue lighten-2" dark dense flat>
      <v-layout row wrap>
        <v-flex xs8>
         <newRecipeModal />
        </v-flex>

        <v-flex xs2>
          <profileModal :user="user"/>
        </v-flex>
      </v-layout>
    </v-card>
  </v-container>
</template>

<script>
import profileModal from "@/components/logged-in/user/profile-modal.vue";
import newRecipeModal from "@/components/logged-in/recipe/newRecipe.vue";
export default {
    components: {
        profileModal,
        newRecipeModal,
    },
    
    data: () => ({
      user: {name: "Volk", firstname: "Alexandra", password: "hash123", email: "platzhalter@mail.com"}  //user account data
    })
        
}
</script>
