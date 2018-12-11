<template>
  <v-container fluid>
    <page-heading>New Questions</page-heading>
    <v-layout justify-center wrap>
      <template v-for="question in questions">
        <card :key="question.id">
          <card-header>
            <v-flex xs6 class="cardHeader__left">
              <span class="font-weight-regular font-italic">{{ question.createdAtFormatted }}</span>
            </v-flex>
            <v-flex xs6 class="cardHeader__right">
              <v-btn icon color="blue-grey--text darken-1--text">
                <v-icon>more_vert</v-icon>
              </v-btn>
            </v-flex>
          </card-header>

          <v-card-text>
            <p class="title">{{ question.text }}</p>
          </v-card-text>

          <v-layout class="stats">
            <v-flex shrink class="statItem">
              <div>
                <v-icon>favorite</v-icon>
              </div>
              <div>
                <span>{{ question.likes }}</span>
              </div>
            </v-flex>
            <v-flex shrink class="statItem">
              <div>
                <v-icon>mode_comment</v-icon>
              </div>
              <div>
                <span>{{ question.comments }}</span>
              </div>
            </v-flex>
          </v-layout>

          <card-footer>
            <template v-for="tag in question.tags">
              <v-chip label outline small color="white" :key="tag.id">{{ tag.title }}</v-chip>
            </template>
          </card-footer>
        </card>
      </template>
    </v-layout>
  </v-container>
</template>

<style scoped>
.cardHeader__right {
  text-align: right;
}
.cardHeader__left {
  padding-left: 20px;
}

.stats {
  display: flex;
  justify-content: flex-end;
  padding-left: 15px;
  padding-bottom: 10px;
}
.statItem {
  display: flex;
  align-items: center;
  margin-right: 15px;
}
.statItem div {
  margin-right: 5px;
}
</style>

<script>
import distanceInWordsToNow from "date-fns/distance_in_words_to_now";

import Card from "@/components/Card.vue";
import CardHeader from "@/components/CardHeader.vue";
import CardFooter from "@/components/CardFooter.vue";
import PageHeading from "@/components/PageHeading.vue";
import { fetchQuestions } from "@/utils/FakerUtils";

export function withDateFormatted(questions) {
  return questions.map(question => {
    const createdAtFormatted = `${distanceInWordsToNow(
      question.createdAt
    )} ago`;

    return { ...question, createdAtFormatted };
  });
}

export default {
  components: {
    Card,
    CardHeader,
    CardFooter,
    PageHeading
  },

  created() {
    fetchQuestions()
      .then(response => {
        this.questions = withDateFormatted(response);
      })
      .catch(console.error);
  },

  data() {
    return {
      questions: []
    };
  }
};
</script>
