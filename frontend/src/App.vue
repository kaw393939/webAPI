<template>
  <v-app id="keep">
    <navigation></navigation>
    <v-content>
      <router-view/>
    </v-content>
  </v-app>
</template>

<script>
import get from "lodash/get";
import { mapMutations } from "vuex";

import Navigation from "@/components/Navigation.vue";
import { getAuthToken, removeAuthToken } from "@/utils/LocalStorageUtils";

export default {
  components: {
    navigation: Navigation
  },

  created() {
    const authToken = getAuthToken();

    if (!authToken) return;

    const handleResponse = response => {
      const { user } = get(response, "data", {});

      this.setAuthUser({
        data: {
          id: user.id,
          name: user.name,
          email: user.email
        }
      });
    };

    const handleError = err => {
      const status = get(err, "response.status", 400);

      const StatusCode = {
        UNAUTHORIZED: 401,
        FORBIDDEN: 403,
        BAD_REQUEST: 400
      };

      if (
        status === StatusCode.FORBIDDEN ||
        status === StatusCode.UNAUTHORIZED ||
        status === StatusCode.BAD_REQUEST
      ) {
        // delete all auth user data
        removeAuthToken();
        this.resetAuthUser();
        delete axios.defaults.headers.common["Authorization"];
        this.$router.push({ path: "/" });
      }
    };

    axios
      .get("/api/user")
      .then(handleResponse)
      .catch(handleError);
  },

  methods: {
    ...mapMutations(["setAuthUser", "resetAuthUser"])
  }
};
</script>
