<template>
  <v-container fluid fill-height>
    <v-layout justify-center>
      <v-flex xs12 sm8 md4>
        <h2 class="headline center">New Questions</h2>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<style>
.center {
  text-align: center;
}
</style>

<script>
export default {
  data() {
    return {
      questions: []
    };
  }
};
</script>

