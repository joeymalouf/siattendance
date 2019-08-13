<template>
  <v-flex xs12 sm11 md7>
    <v-card elevation="12">
      <v-toolbar dark color="red" height="36px">
        <v-toolbar-title>Error</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>
      <v-card-text>
        An error has occurred. Try reloading the previous page. This error is usually caused by not having an 
        account setup, or not being logged in.
        If refeshing does not fix the issue, try restarting your browser or using a different one.
        If this doesnt work contact your SI Leader.
        This error could also occur if the server cannot reach the database.
      </v-card-text>
    </v-card>
  </v-flex>
</template>
<script>
export default {
  name: "error",
  data() {
    return {};
  },
  methods: {}
};
</script>

