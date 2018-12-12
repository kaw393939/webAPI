<template>
  <v-app id="keep">
    <navigation></navigation>
    <v-content>
      <router-view/>
    </v-content>
  </v-app>
</template>

<script>
import Navigation from "./components/Navigation.vue";

export default {
    components: {
        navigation: Navigation
    }
};
</script>
