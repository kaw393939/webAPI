<template>
  <v-form class="flex xs12 sm10 md8 lg8 xl4 container">
    <div>
      <v-textarea solo name="answer area" label="Answer question here"></v-textarea>
      <div class="area-btn-wrapper">
        <v-btn class="area-btn">Submit</v-btn>
      </div>
    </div>
  </v-form>
</template>

<style scoped>
.area-btn {
  margin: 0;
  color: #fff;
}
.area-btn-wrapper {
  width: 100%;
  display: flex;
  justify-content: flex-end;
  align-items: center;
}
.theme--light.v-btn:not(.v-btn--icon):not(.v-btn--flat) {
  background-color: rgb(25, 118, 210);
  color: #fff;
}
</style>

<script>
export default {
  Data() {}
};
</script>