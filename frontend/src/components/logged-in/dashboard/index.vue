<template>
  <div>
    <v-layout row wrap>
      <v-flex xs12>
        <subtoolbar/>
        <searchbox/>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
import searchbox from "@/components/logged-in/dashboard/searchbox.vue";
import subtoolbar from "@/components/logged-in/dashboard/toolbar.vue";
export default {
  components: {
    searchbox,
    subtoolbar
  }
};
</script>
