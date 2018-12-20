<template>
  <div>
    <v-navigation-drawer v-model="drawer" fixed class="grey lighten-4" app>
      <v-list dense class="grey lighten-4">
        <template v-for="(item, i) in navLinks">
          <v-divider v-if="item.divider" :key="i" dark class="my-3"></v-divider>
          <v-list-tile v-else :key="i">
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <router-link :to="item.href" style="text-decoration: none;">
                <v-list-tile-title class="black--text body-2">{{ item.text }}</v-list-tile-title>
              </router-link>
            </v-list-tile-content>
          </v-list-tile>
        </template>
        <v-list-tile v-if="isUserLoggedIn">
          <v-list-tile-action>
            <v-icon>fa-sign-out-alt</v-icon>
          </v-list-tile-action>
          <router-link @click.native="handleLogout" to="/" style="text-decoration: none;">
            <v-list-tile-title class="black--text body-2">Logout</v-list-tile-title>
          </router-link>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar style="background: #1976d2" app>
      <v-toolbar-side-icon @click.native="drawer = !drawer" class="white--text"></v-toolbar-side-icon>
      <span class="title ml-3 mr-5 white--text">FAQBot</span>
      <v-text-field
        solo-inverted
        flat
        hide-details
        label="Search"
        prepend-inner-icon="search"
        class="white--text"
      ></v-text-field>
      <v-spacer></v-spacer>
    </v-toolbar>
  </div>
</template>

<script>
import pick from "lodash/pick";
import { mapGetters, mapMutations } from "vuex";
import { removeAuthToken } from "@/utils/LocalStorageUtils";

export default {
  data() {
    return {
      drawer: null,

      navItems: [
        { href: "/", text: "Home", icon: "fa-home" },
        { divider: true },
        { href: "/login", text: "Login", icon: "fa-sign-in-alt" },
        { href: "/register", text: "Register", icon: "fa-user-plus" },
        { href: "/profile/:id", text: "Profile", icon: "fa-user" }
      ]
    };
  },

  computed: {
    ...mapGetters(["isLoggedIn"]),

    navLinks: function() {
      const excludedItemsIfAuthenticated = ["/login", "/register"];
      const excludedItemsIfNotAuthenticated = ["/profile/:id"];

      const navItemsBeforeAuth = this.navItems.filter(
        item => !excludedItemsIfNotAuthenticated.includes(item.href)
      );
      const navItemsAfterAuth = this.navItems
        .filter(item => !excludedItemsIfAuthenticated.includes(item.href))
        .map(item => {
          if (item.href !== "/profile/:id") return item;

          // Get userId from global store when ready
          // const userId = this.authUser.id || 1
          const userId = 1;

          return {
            ...item,
            href: item.href.replace(":id", userId)
          };
        });

      return this.isLoggedIn ? navItemsAfterAuth : navItemsBeforeAuth;
    },

    isUserLoggedIn: function() {
      return this.isLoggedIn;
    }
  },

  methods: {
    ...mapMutations(["resetAuthUser"]),

    handleLogout: function() {
      const logUserOut = () => {
        removeAuthToken();
        this.resetAuthUser();
        delete axios.defaults.headers.common["Authorization"];
      };

      axios
        .post("api/logout")
        .then(logUserOut)
        .catch(logUserOut);
    }
  }
};
</script>
