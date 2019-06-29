<template>
  <v-container>
    <!--  <v-breadcrumbs :items="breadcrumbs" divider=">"></v-breadcrumbs>-->
    <v-layout row wrap>
      <v-flex xs12>
        <v-card color="teal lighten-2" dark>
          <v-card-title class="headline teal lighten-3">
            <v-form v-if="edit">
              <v-text-field :counter="25" label="Titel" :value="recipeName" required></v-text-field>
            </v-form>
            <p v-else class="text-xs-center display-3">{{recipeName}}</p>
          </v-card-title>
          <v-card-text>
            <v-layout row wrap>
              <v-flex xs6>
                <v-img src="https://picsum.photos/510/300?random" aspect-ratio="1.4"></v-img>
                <v-form v-if="edit">
                  <v-text-field label="URL zum Bild" :value="name"></v-text-field>
                </v-form>
              </v-flex>
              <v-flex xs6>
                <v-card flat color="teal darken-2">
                  <v-card-title dense>Zutaten</v-card-title>
                  <v-divider></v-divider>
                  <v-list v-if="!edit" class="teal darken-1">
                    <v-list-tile v-for="n in components" :key="n">
                      <v-list-tile-content>{{n.name}}</v-list-tile-content>
                      <v-list-tile-content class="align-end">{{ n.amount }} {{n.unit}}</v-list-tile-content>
                    </v-list-tile>
                  </v-list>
                  <v-form v-else>
                    <v-list class="teal darken-1">
                      <v-container
                        v-for="n in components"
                        :key="n"
                        grid-list-xs
                        style="margin-top: -3.5%;"
                      >
                        <v-layout row wrap>
                          <v-flex xs7>
                            <v-text-field @change="addComponent" label="Zutat" :value="n.name"></v-text-field>
                          </v-flex>
                          <v-flex xs2>
                            <v-text-field label="Menge" :value="n.amount"></v-text-field>
                          </v-flex>
                          <v-flex xs2>
                            <v-select :items="units" value="n.unit" label="Einheit"></v-select>
                          </v-flex>
                          <v-flex xs1></v-flex>
                        </v-layout>
                      </v-container>
                    </v-list>
                  </v-form>
                  <v-card-actions v-if="edit">
                    <v-spacer></v-spacer>
                  <v-btn @click="addComponent()">
                    <v-icon>add</v-icon>
                  </v-btn>
                  <v-btn color="red lighten-2" @click="clearComponent()">
                    <v-icon>clear</v-icon>
                  </v-btn>
                  <v-btn @click="removeComponent()">
                    <v-icon>remove</v-icon>
                  </v-btn>
                  <v-spacer></v-spacer>
                  </v-card-actions>
                  
                </v-card>
              </v-flex>
              <v-flex xs12>
                <p v-if="!edit">Zeit gesamt: {{(timings.prep + timings.oven)/60}}h Zubereitung: {{timings.prep}}min Im Ofen/Topf: {{timings.oven}}min</p>
                <v-form v-else >
                  <v-layout row wrap>
                   <v-flex xs3>
                      <v-text-field @change="addComponent" append="min" label="Zubereitung (min)" :value="timings.prep"></v-text-field> 
                   </v-flex>
                  <v-flex xs3>
                    <v-text-field @change="addComponent" label="Kochzeit (min)" append="min" :value="timings.oven"></v-text-field>
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
            <v-btn absolute dark top right color="grey" icon @click="this.toggleEdit">
              <v-icon v-if="!edit">settings</v-icon>
              <v-icon v-else>save</v-icon>
            </v-btn>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {
  props: {
    edit: Boolean
  },
  data: () => ({
    recipeName: "Hackbraten",
    components: [
      { name: "Zucker", amount: "450", unit: "g" },
      { name: "Mehl", amount: "1", unit: "kg" }
    ],
    steps: "This is where your text is",
    timings: {
      prep: 40,
      oven: 80
    },
    breadcrumbs: [
      {
        text: "Übersicht",
        disabled: false,
        to: "dashboard"
      }
    ],
    units: [
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
    ]
  }),
  methods: {
    toggleEdit() {
      this.edit = !this.edit;
      let additional = {
        text: "Bearbeiten",
        disabled: true
      };
      if (this.edit) {
        this.breadcrumbs.push(additional);
      } else {
        this.breadcrumbs.pop();
      }
    },
    removeComponent() {
      this.components.pop();
      if (this.components.length == 0) {
        this.addComponent();
      }
    },
    addComponent() {
      let componentDummy = { name: "", amount: "", unit: "" };
      this.components.push(componentDummy);
    },
    clearComponent() {
      do{
        this.removeComponent();
      }while(this.components.length > 1);
      this.removeComponent(); // call again to add a empty component again
    }
  }
};
</script>