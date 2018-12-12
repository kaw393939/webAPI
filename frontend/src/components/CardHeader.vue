<template>
  <v-layout align-center :class="classes">
    <slot></slot>
  </v-layout>
</template>

<script>
export default {
  props: {
    classes: String,
    default: ""
  }
};
</script>
