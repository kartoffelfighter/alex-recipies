<template>
  <v-container>
    <v-card color="teal lighten-2" dark>
      <v-card-title class="headline teal lighten-3">
        Suche nach Rezepten
        <v-spacer></v-spacer>
        <v-btn v-if="!random" color="grey darken-3" @click="rand()">Zufällig</v-btn>
        <v-btn v-else color="grey darken-3" @click="rand()">Nochmal</v-btn>
      </v-card-title>
      <v-card-text>
        <v-autocomplete
          v-model="model"
          :items="items"
          :search-input.sync="search"
          color="white"
          hide-no-data
          hide-selected
          label="Stichwortsuche"
          placeholder="Käsebrot..."
          prepend-icon="search"
        ></v-autocomplete>
        <router-link :disabled="!model" :to="{path: '/recipe/'+this.getRecipeId()}"><v-btn block success >Anzeigen</v-btn></router-link>
      </v-card-text>
    </v-card>
  </v-container>
</template>


<script>
export default {
  props: {
    recipeId: String,
    random: Boolean,
  },
  data: () => ({
    entries: [],
    model: null,
    search: null,
  }),
  computed: {
    items() {
      return this.$store.state.recipeIndex;
    }
  },
  methods: {
    rand() {
      this.random = true;
      let min = 0; // minimum recipe id
      let max = this.items.length; // maximum recipe id, identical to the length of the items array
      this.recipeId = Math.floor(Math.random() * (max - min + 1)) + min;
      this.model = this.items[this.recipeId];
    },
    getRecipeId(){
      return this.$store.state.recipeIndex.indexOf(this.model) + 1;
    }
  }
};
</script>