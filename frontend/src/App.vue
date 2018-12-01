<template>
  <v-app id="keep">
    <navigation></navigation>
    <v-content class="content">
      <router-view/>
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


<style>
.content {
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
