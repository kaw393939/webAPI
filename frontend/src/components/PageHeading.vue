<template>
  <v-layout justify>
    <v-flex xs12>
      <h2 class="heading headline text-lg-center text-md-center text-sm-center text-xs-center">
        <slot></slot>
      </h2>
    </v-flex>
  </v-layout>
</template>

<style scoped>
.heading {
  margin-top: 15px;
  margin-bottom: 15px;
}
</style>
