<template>
  <v-flex xs12 sm10 md8 lg8 xl4 :class="stylingClasses">
    <v-card class="elevation-2" :to="routerLink">
      <slot></slot>
    </v-card>
  </v-flex>
</template>


<style scoped>
.container {
  margin: 20px 15px;
}
</style>

<script>
export default {
  props: {
    classes: {
      type: String,
      default: ""
    },
    path: {
      type: String,
      default: null
    }
  },

  computed: {
    stylingClasses() {
      return `container ${this.classes}`;
    },

    routerLink() {
      if (this.path) {
        return this.path;
      }
    }
  }
};
</script>
