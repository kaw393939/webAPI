<template>
  <v-container fluid>
    <page-heading>Question</page-heading>

    <template v-if="questionDidFetch">
      <v-layout justify-center>
        <card classes="card">
          <aside class="aside">
            <v-layout column align-center justify-space-around fill-height>
              <v-flex xs2>
                <v-btn flat icon color="blue darken-2">
                  <v-icon x-large>expand_less</v-icon>
                </v-btn>
              </v-flex>
              <v-flex xs2>
                <span class="blue--text text--darken-2">{{ question.votes }}</span>
              </v-flex>
              <v-flex xs2>
                <v-btn flat icon color="blue darken-2">
                  <v-icon x-large>expand_more</v-icon>
                </v-btn>
              </v-flex>
              <v-flex xs2>
                <v-btn flat icon color="blue darken-2">
                  <v-icon>favorite</v-icon>
                </v-btn>
              </v-flex>
              <v-flex xs2>
                <span class="blue--text text--darken-2">{{ question.likes }}</span>
              </v-flex>
            </v-layout>
          </aside>

          <card-header classes="header">
            <v-flex xs3 sm2 class="headerRow">
              <v-avatar color="grey lighten-4">
                <img :src="question.author.avatar" alt="avatar">
              </v-avatar>
            </v-flex>
            <v-flex xs6 sm7 class="headerRow">
              <p class="subheading font-weight-bold">{{ question.author.fullName }}</p>
            </v-flex>
            <v-flex xs3 sm3 class="headerRow">
              <p class="body-1 font-italic">{{ question.createdAtFormatted }}</p>
            </v-flex>
          </card-header>

          <v-card-text>
            <p class="title">{{ question.text }}</p>
          </v-card-text>

          <card-footer>
            <template v-for="tag in question.tags">
              <v-chip label outline small color="white" :key="tag">{{ tag.title }}</v-chip>
            </template>
          </card-footer>
        </card>
      </v-layout>

      <v-layout align-center>
        <v-flex xs6 class="answersCountWrapper">
          <p class="headline">{{ answers.length }} Answers</p>
        </v-flex>
        <v-flex xs6 class="addAnswerButtonWrapper">
          <v-btn fab dark small color="blue darken-2">
            <v-icon dark>add</v-icon>
          </v-btn>
        </v-flex>
      </v-layout>

      <template v-for="(answer, index) in answers">
        <v-layout justify-center :key="index">
          <card classes="card">
            <aside class="aside">
              <v-layout column align-center justify-space-around fill-height>
                <v-flex xs4>
                  <v-btn flat icon color="blue darken-2">
                    <v-icon x-large>expand_less</v-icon>
                  </v-btn>
                </v-flex>
                <v-flex xs4>
                  <span class="blue--text text--darken-2">{{ question.votes }}</span>
                </v-flex>
                <v-flex xs4>
                  <v-btn flat icon color="blue darken-2">
                    <v-icon x-large>expand_more</v-icon>
                  </v-btn>
                </v-flex>
              </v-layout>
            </aside>

            <card-header classes="header">
              <v-flex xs2 class="headerRow">
                <v-avatar color="grey lighten-4">
                  <img :src="answer.author.avatar" alt="avatar">
                </v-avatar>
              </v-flex>
              <v-flex xs7 class="headerRow">
                <p class="subheading font-weight-bold">{{ answer.author.fullName }}</p>
              </v-flex>
              <v-flex xs3 class="headerRow">
                <p class="body-1 font-italic">{{ answer.createdAtFormatted }}</p>
              </v-flex>
            </card-header>

            <v-card-text>
              <p class="title">{{ answer.text }}</p>
            </v-card-text>
          </card>
        </v-layout>
      </template>
    </template>
  </v-container>
</template>

<style scoped>
.card {
  position: relative;
  margin-left: 25px;
}

.aside {
  position: absolute;
  top: 50%;
  bottom: 50%;
  left: -55px;
  width: 55px;
}

.header {
  padding: 5px 15px;
}
.headerRow p {
  margin: 0;
}
.headerRow:nth-child(3) {
  text-align: right;
}

.answersCountWrapper {
  text-align: right;
  margin-right: 10px;
}
.answersCountWrapper p {
  margin: 0;
}
.addAnswerButtonWrapper {
  margin-left: 10px;
}
</style>

<script>
import distanceInWordsToNow from "date-fns/distance_in_words_to_now";
import flow from "lodash/flow";
import get from "lodash/get";
import isEmpty from "lodash/isEmpty";
import isNil from "lodash/isNil";

import Card from "@/components/Card.vue";
import CardFooter from "@/components/CardFooter.vue";
import CardHeader from "@/components/CardHeader.vue";
import PageHeading from "@/components/PageHeading.vue";

import { fetchQuestion } from "@/utils/FakerUtils";

export default {
  components: {
    Card,
    CardFooter,
    CardHeader,
    PageHeading
  },

  data() {
    return {
      answers: [],
      question: {}
    };
  },

  created() {
    const { id } = this.$route.params;

    if (isNil(id)) return;

    const handleResponse = question => {
      const withFormattedDate = item => ({
        ...item,
        createdAtFormatted: `${distanceInWordsToNow(item.createdAt)} ago`
      });
      const withAuthorFullName = item => ({
        ...item,
        author: {
          ...item.author,
          fullName: `${item.author.firstName} ${item.author.lastName}`
        }
      });

      const withFormattedAttrs = flow([withFormattedDate, withAuthorFullName]);

      return {
        ...withFormattedAttrs(question),
        answers: question.answers.map(withFormattedAttrs)
      };
    };

    const setState = ({ answers, ...question }) => {
      this.answers = answers;
      this.question = question;
    };

    fetchQuestion(id)
      .then(handleResponse)
      .then(setState)
      .catch(console.error);
  },

  computed: {
    questionDidFetch() {
      return !isEmpty(this.question);
    },

    questionAuthorFullName() {
      const { firstName, lastName } = this.question.author;

      return `${firstName} ${lastName}`;
    }
  }
};
</script>
