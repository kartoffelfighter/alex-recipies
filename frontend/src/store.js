import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    currentUser: {
      jwt: '0000',
      firstname: 'Test',
      lastname: 'Harald',
      email: 'test@harald.me',
    },
    currentRecipies: {
      1: {
        name: "Hackbraten",
        ingredients: [
          { name: "Zucker", amount: "450", unit: "g" },
          { name: "Mehl", amount: "1", unit: "kg" }
        ],
        steps: "This is where your text is",
        timings: {
          prep: 40,
          oven: 80
        },
      },
      2: {
        name: "Katzenkotlett",
        ingredients: [
          { name: "Zucker", amount: "450", unit: "g" },
          { name: "Mehl", amount: "1", unit: "kg" }
        ],
        steps: "This is where your text is",
        timings: {
          prep: 40,
          oven: 80
        },
      },
      3: {
        name: "Käsebrot",
        ingredients: [
          { name: "Zucker", amount: "450", unit: "g" },
          { name: "Mehl", amount: "1", unit: "kg" }
        ],
        steps: "This is where your text is",
        timings: {
          prep: 40,
          oven: 80
        },
      },
    },
    recipeIndex: ["Hackbraten", "Katzenkotlett", "Käsebrot"],

  },
  mutations: {
    editRecipe(id, payload){
      this.state.currentRecipies[id] = payload;
    },
    editRecipiesTitle(id, recipeName){
      this.state.currentRecipies[id].name = recipeName;
    },
    addRecipiesIngredient(id, ingredient){
      this.state.currentRecipies[id].ingredients.push(ingredient);
    },
    removeRecipiesIngredient(id){
      this.state.currentRecipies[id].ingredients.pop();
      if(this.state.currentRecipies[id].ingredients.length == 0){
        this.state.currentRecipies[id].ingredients.push({name:  "", amount: "", unit: ""});
      }
    },




  },
  actions: {

  },
  getters: {

  }
});
