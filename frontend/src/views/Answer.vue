<template>
  <answer-area/>
</template>
<style scoped>
</style>

<script>
import AnswerArea from "../components/AnswerArea";
export default {
  components: {
    AnswerArea
  },
  Data() {},

  created: function() {
    return axios
      .get("api/questions/1")
      .then(res => console.log(res))
      .catch(err => console.log(err));
  }
};
</script>