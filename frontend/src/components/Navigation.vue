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

import { routes } from "@/router";
import { removeAuthToken } from "@/utils/LocalStorageUtils";

function isNavItem(route) {
  const navItems = ["/login", "/register"];

  return navItems.includes(route.href);
}

function withAdditionalAttributes(route) {
  switch (route.href) {
    case "/login":
      return { ...route, icon: "fa-sign-in-alt", text: "Login" };
    case "/register":
      return { ...route, icon: "fa-user-plus", text: "Register" };
    default:
      return route;
  }
}

export default {
  data() {
    return {
      drawer: null,

      navItems: routes
        .map(route => pick(route, ["path"]))
        .map(route => ({ href: route.path }))
        .filter(isNavItem)
        .map(withAdditionalAttributes)
        .concat([
          { divider: true },
          { icon: "fa-home", text: "Home", href: "/" }
        ])
        .reverse()
    };
  },

  computed: {
    ...mapGetters(["isLoggedIn"]),

    navLinks: function() {
      return this.isLoggedIn
        ? this.navItems.filter(({ href }) => {
            const excluded = ["/login", "/register"];

            return !excluded.includes(href);
          })
        : this.navItems;
    },

    isUserLoggedIn: function() {
      return this.isLoggedIn;
    }
  },

  methods: {
    ...mapMutations(["resetAuthUser"]),

    handleLogout: function() {
      const handleResponse = response => {
        removeAuthToken();
        this.resetAuthUser();
      };

      const handleError = error => {
        removeAuthToken();
        this.resetAuthUser();
      };

      axios
        .get("api/logout")
        .then(handleResponse)
        .catch(handleError);
    }
  }
};
</script>
