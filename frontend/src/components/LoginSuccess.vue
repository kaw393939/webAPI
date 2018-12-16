<template>
  <div>
    <div class="text-xs-center">
      <v-btn color="primary" @click="alert = !alert">Toggle</v-btn>
    </div>
    <v-alert :value="alert" type="success" transition="scale-transition">This is a success alert.</v-alert>
    <v-btn color="success">Success</v-btn>
  </div>
</template>

<script>
export default {
  data() {}
};
</script>