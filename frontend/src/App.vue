<template>
  <v-app id="keep">
    <navigation></navigation>
    <v-content>
      <v-container fluid fill-height>
        <router-view/>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import Navigation from "./components/Navigation";

export default {
  components: {
    navigation: Navigation
  }
};
</script>
