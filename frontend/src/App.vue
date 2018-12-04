<template>
  <v-app id="keep">
    <navigation></navigation>
    <v-content>
      <!--<router-view/>-->
      <!--<login></login>-->
      <edit-profile></edit-profile>
    </v-content>
  </v-app>
</template>

<script>
import Navigation from "./components/Navigation.vue";
import Login from "./views/Login.vue";
import editProfile from "./views/editProfile.vue";

export default {
  components: {
    navigation: Navigation,
    login: Login,
      editProfile: editProfile,
  }
};
</script>
