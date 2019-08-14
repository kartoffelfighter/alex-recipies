<template>
  <v-snackbar v-model="visible" color="green lighten-2" top>
    {{message}}
    <v-btn color="pink" flat @click="dismiss()">Close</v-btn>
  </v-snackbar>
</template>

<script>
export default {
  data: () => ({
    visible: false,
    message: null
  }),
  methods: {
    dismiss() {
      this.$store.dispatch("DISMISS_NOTIFY");
    }
  },
  created: function() {
    this.$store.watch(
      state => state.notify,
      () => {
        this.message = this.$store.getters.NOTIFYMSG;
        this.visible = true;
      }
    );
  }
};
</script>
