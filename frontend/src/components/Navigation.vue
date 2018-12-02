<template>
  <div>
    <v-navigation-drawer v-model="drawer" fixed clipped class="grey lighten-4" app>
      <v-list dense class="grey lighten-4">
        {{isLogged}}
        <template v-if="isLogged">
         <template v-for="(item, i) in afterLogin">
          <v-divider v-if="item.divider" :key="i" dark class="my-3"></v-divider>
          <v-list-tile v-else :key="i">
            <v-list-tile-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
              <v-list-tile-title class="black--text body-2">{{ item.text }}</v-list-tile-title>
            </v-list-tile-content>
          </v-list-tile>
        </template>
        </template>
       
        <template v-else>
          <template v-for="(item, i) in navItems">
            <v-divider v-if="item.divider" :key="i" dark class="my-3"></v-divider>
            <v-list-tile v-else :key="i">
              <v-list-tile-action>
                <v-icon>{{ item.icon }}</v-icon>
              </v-list-tile-action>
              <v-list-tile-content>
                <v-list-tile-title class="black--text body-2">{{ item.text }}</v-list-tile-title>
              </v-list-tile-content>
            </v-list-tile>
          </template>
        </template>

      </v-list>
    </v-navigation-drawer>
    <v-toolbar color="blue-grey" app absolute clipped-left>
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
import { mapGetters, mapActions } from "vuex";
import { EventBus } from "../utilities/eventBus.js";
import router from "../router";

const navItemConst = [
  { icon: "home", text: "Home", href: "/" },
  { divider: true },
  { icon: "question_answer", text: "NJIT FAQ Bot", href: "/" },
  { icon: "info", text: "About", href: "/" }
];

export default {
  data: () => ({
    drawer: null,
    navItems: [
      ...navItemConst,
      { icon: "account-box", text: "Login", href: "/login" },
      { icon: "account-box", text: "Register", href: "/register" }
    ],
    navItemsAfterAuth: [...navItemConst]
  }),

  created() {
    this.isLogged();
    this.getUser();
  },

  computed: {
    ...mapGetters(["isLoggedIn", "user"]),
    afterLogin: function() {
      return this.navItemsAfterAuth.map(item => {
        return item;
      });
    },
    beforeLogin: function() {
      return this.navItems.map(item => {
        return item;
      });
    }
  },
  methods: {
    ...mapActions(["getUserDetails"]),
    isLogged: function() {
      EventBus.$on("logged", (user) => {
        console.log("user", user);
        return user.token ? this.isLogged = true : this.isLogged = false;
      });
    },
    getUser: function() {
      const user = this.getUserDetails();
      console.log("USER", user);
  }
}}
</script>
