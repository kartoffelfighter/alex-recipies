<template>
  <v-container grid-list-md>
    <v-layout row wrap v-if="name">
      <v-flex xs12>
        <v-system-bar window dark v-if="!dialog">
          <router-link v-if="!dialog" to="/dashboard">
            <v-btn icon>
              <v-icon>arrow_back</v-icon>
            </v-btn>
          </router-link>
          <v-btn v-else icon @clicked="this.$emit(dialog, false)">
            <v-icon>close</v-icon>
          </v-btn>
          <v-spacer></v-spacer>
          <v-btn v-if="!edit" icon @click="edit = true">
            <v-icon>settings</v-icon>
          </v-btn>
          <v-btn v-else icon @click="save()">
            <v-icon>save</v-icon>
          </v-btn>
        </v-system-bar>
        <v-card color="blue-grey lighten-2" dark>
          <v-card-title class="headline blue-grey lighten-3">
            <v-form v-if="edit">
              <v-text-field :counter="25" label="Titel" :value="name" required></v-text-field>
            </v-form>
            <p v-else class="text-xs-center display-3">{{name}}</p>
          </v-card-title>
          <v-card-text>
            <v-layout row wrap>
              <v-flex xs6>
                <v-img src="https://picsum.photos/510/300?random" aspect-ratio="1.4"></v-img>
                <v-form v-if="edit">
                  <v-text-field label="URL zum Bild" :value="name"></v-text-field>
                </v-form>
              </v-flex>
              <v-spacer></v-spacer>
              <v-flex xs6>
                <v-card flat color="blue-grey darken-2">
                  <v-card-title dense>Zutaten</v-card-title>
                  <v-divider></v-divider>
                  <v-list v-if="!edit" class="blue-grey darken-1">
                    <v-list-tile v-for="n in ingredients" :key="n">
                      <v-list-tile-content>{{n.name}}</v-list-tile-content>
                      <v-list-tile-content class="align-end">{{ n.amount }} {{n.unit}}</v-list-tile-content>
                    </v-list-tile>
                  </v-list>
                  <v-form v-else>
                    <v-list class="blue-grey darken-1">
                      <v-container
                        v-for="n in ingredients"
                        :key="n"
                        grid-list-xs
                        style="margin-top: -3.5%;"
                      >
                        <v-layout row wrap>
                          <v-flex xs7>
                            <v-text-field @change="addIngredient()" label="Zutat" :value="n.name"></v-text-field>
                          </v-flex>
                          <v-flex xs2>
                            <v-text-field label="Menge" :value="n.amount"></v-text-field>
                          </v-flex>
                          <v-flex xs2>
                            <v-select :items="units" :value="n.unit" label="Einheit"></v-select>
                          </v-flex>
                          <v-flex xs1></v-flex>
                        </v-layout>
                      </v-container>
                    </v-list>
                  </v-form>
                  <v-card-actions v-if="edit">
                    <v-spacer></v-spacer>
                    <v-btn @click="addIngredient()">
                      <v-icon>add</v-icon>
                    </v-btn>
                    <v-btn color="red lighten-2" @click="clearIngredient()">
                      <v-icon>clear</v-icon>
                    </v-btn>
                    <v-btn @click="removeIngredient()">
                      <v-icon>remove</v-icon>
                    </v-btn>
                    <v-spacer></v-spacer>
                  </v-card-actions>
                </v-card>
              </v-flex>
              <v-flex xs12>
                <p
                  v-if="!edit"
                >Zeit gesamt: {{(timings.prep + timings.oven)/60}}h Zubereitung: {{timings.prep}}min Im Ofen/Topf: {{timings.oven}}min</p>
                <v-form v-else>
                  <v-layout row wrap>
                    <v-flex xs3>
                      <v-text-field
                        @change="ingredients = addIngredient"
                        append="min"
                        label="Zubereitung (min)"
                        :value="timings.prep"
                      ></v-text-field>
                    </v-flex>
                    <v-flex xs3>
                      <v-text-field
                        @change="ingredients = addIngredient"
                        label="Kochzeit (min)"
                        append="min"
                        :value="timings.oven"
                      ></v-text-field>
                    </v-flex>
                  </v-layout>
                </v-form>
              </v-flex>
              <v-flex v-if="!edit" xs12>
                <h2>Zubereitung</h2>
                <div v-html="steps"></div>
              </v-flex>
              <v-flex v-else xs12>
                <h2>Zubereitung</h2>
                <vue-editor v-model="steps"></vue-editor>
              </v-flex>
            </v-layout>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
    <v-layout v-else>
      <p>Loading..
        {{name}}
      </p>
    </v-layout>
  </v-container>
</template>

<script>

export default {
  props: {
    dialog: Boolean,
    id: String,
    name: String,
    ingredients: Array,
    steps: String,
    timings: Array,
    units: Array
  },
  data: () => ({
    edit: false
  }),
  methods: {
    toggleEdit() {
      this.edit = !this.edit;
      if (this.edit) {
        this.setProperties();
      }
    },
    removeIngredient() {
      this.$store.commit("removeIngredient", this.id);
    },
    addIngredient() {
      this.ingredients.push({ name: "", amount: "", unit: "" });
    },
    clearIngredient() {
      do {
        this.removeIngredient();
      } while (this.ingredients.length > 1);
      this.removeIngredient(); // call again to add a empty component again
    },
    disableDialog() {
      this.$emit("dialog", false);
    }
  },
  mounted: function() {
    let id =  this.$route.params["id"];
    this.name = this.computeName.get(id);
    //this.ingredients = this.getProperties["ingredients"];
    //this.steps = this.getProperties["steps"];
    //this.timings = this.getProperties["timings"];
    //this.id = this.getProperties["id"];
    this.units = [
      "g",
      "kg",
      "ml",
      "l",
      "pck",
      "geh.  EL",
      "gstr. EL",
      "geh.  TL",
      "gstr. TL",
      "Tasse",
      "Prise"
    ];
  },
  computed: {
   computeName: {
     get(id){
       return this.$store.getters.recipeName(id)
     }
   }
  }
};
</script>