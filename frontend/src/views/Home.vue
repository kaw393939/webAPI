<template>
  <v-container fluid>
    <page-heading>New Questions</page-heading>
    <v-layout justify-center wrap>
      <template v-for="question in questions">
        <card :key="question.id" :path="question.path" classes="card">
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

    <v-btn v-if="userAuthenticated" fab fixed bottom right to="/question" color="primary">
      <v-icon>add</v-icon>
    </v-btn>
  </v-container>
</template>

<style scoped>
.card {
  transition: transform 0.5s ease-in-out;
}
.card:hover {
  transform: scale(1.025);
}

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
import { mapGetters } from "vuex";
import get from "lodash/get";

import Card from "@/components/Card.vue";
import CardHeader from "@/components/CardHeader.vue";
import CardFooter from "@/components/CardFooter.vue";
import PageHeading from "@/components/PageHeading.vue";
import { fetchQuestions } from "@/utils/FakerUtils";
import {
  withFormattedDate,
  withQuestionAnswerCount
} from "@/utils/ApiResponseUtils";

export default {
  components: {
    Card,
    CardHeader,
    CardFooter,
    PageHeading
  },
  data() {
    return {
      questions: []
    };
  },

  data() {
    return {
      isLoading: false,
      questions: []
    };
  },

  created() {
    const handleResponse = response => {
      let questions = get(response, "data.data", []);

      // grab first 30 for now, no pagination on API side
      // as the time of writing this implementation
      questions = Array.isArray(questions) ? questions.slice(0, 30) : [];
      questions = questions.map(question =>
        withFormattedDate(question, "createdAt.date")
      );
      questions = questions.map(question => withQuestionAnswerCount(question));

      console.log("questions", questions[0]);
    };

    const handleError = error => {
      console.log("error", error);
      this.isLoading = false;
    };

    this.isLoading = true;

    axios
      .get("api/questions")
      .then(handleResponse)
      .catch(handleError);

    fetchQuestions()
      .then(response => {
        this.questions = response.map(withFormattedDate).map(question => ({
          ...question,
          path: `/question/${question.id}`
        }));
      })
      .catch(console.error);
  },

  computed: {
    ...mapGetters(["isLoggedIn"]),

    userAuthenticated() {
      return this.isLoggedIn ? true : false;
    }
  }
};
</script>
