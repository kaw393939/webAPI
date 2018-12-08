<template>
  <v-flex xs12 sm10 md8 lg8 xl4 class="container">
    <v-card class="elevation-2">
      <slot></slot>
    </v-card>
  </v-flex>
</template>


<style scoped>
.container {
  margin: 20px 15px;
}
</style>
