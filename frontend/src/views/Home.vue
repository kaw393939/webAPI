<template>
  <v-container fluid>
    <page-heading>New Questions</page-heading>
    <v-layout justify-center wrap>
      <template v-for="question in questions">
        <v-flex xs12 sm10 md8 lg8 xl4 class="question" :key="question.id">
          <v-card class="card elevation-2">
            <v-layout align-center class="cardHeader">
              <v-flex xs6 class="cardHeader__left">
                <span class="font-weight-regular font-italic">{{ question.createdAtFormatted }}</span>
              </v-flex>
              <v-flex xs6 class="cardHeader__right">
                <v-btn icon color="blue-grey--text darken-1--text">
                  <v-icon>more_vert</v-icon>
                </v-btn>
              </v-flex>
            </v-layout>

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

            <v-layout class="blue darken-2 tags" wrap>
              <template v-for="tag in question.tags">
                <v-chip label outline small color="white" :key="tag">{{ tag }}</v-chip>
              </template>
            </v-layout>
          </v-card>
        </v-flex>
      </template>
    </v-layout>
  </v-container>
</template>

<style scoped>
.question {
  margin: 20px 15px;
}

.cardHeader__right {
  text-align: right;
}
.cardHeader__left {
  padding-left: 15px;
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

.tags {
  padding: 10px 15px;
}
</style>

<script>
import distanceInWordsToNow from "date-fns/distance_in_words_to_now";

import PageHeading from "@/components/PageHeading.vue";

function fetchQuestions() {
  return Promise.resolve([
    {
      id: 1,
      text: "How hard are the math courses at NJIT?",
      tags: ["math", "course", "njit", "final", "exam", "time"],
      createdAt: "2018-08-05T19:25:45.805Z",
      likes: 5,
      comments: 10
    },
    {
      id: 2,
      text: "What is the Math Placement Exam?",
      tags: ["multiple", "math", "course", "njit", "final", "exam", "time"],
      createdAt: "2018-08-05T19:25:45.805Z",
      likes: 5,
      comments: 10
    },
    {
      id: 3,
      text: "I suck at Math and need help.",
      tags: ["multiple", "math", "course", "njit", "final", "exam"],
      createdAt: "2018-08-05T19:25:45.805Z",
      likes: 5,
      comments: 10
    },
    {
      id: 4,
      text: "What will be on the Math 110 spring 2018 final exam?",
      tags: ["multiple", "course", "njit", "final", "exam", "time"],
      createdAt: "2018-08-05T19:25:45.805Z",
      likes: 5,
      comments: 10
    },
    {
      id: 5,
      text: "Graphing Calculator for Computer Science Major.",
      tags: ["multiple", "math", "course", "njit", "final", "exam", "time"],
      createdAt: "2018-08-05T19:25:45.805Z",
      likes: 5,
      comments: 10
    },
    {
      id: 6,
      text: "What are the office hours for MATH 211-002 with professor Smith?",
      tags: ["multiple", "math", "njit", "final", "exam", "time"],
      createdAt: "2018-08-05T19:25:45.805Z",
      likes: 5,
      comments: 10
    },
    {
      id: 7,
      text: "What will be on the Math 110 spring 2018 final exam?",
      tags: ["multiple", "math", "course", "final", "exam", "time"],
      createdAt: "2018-08-05T19:25:45.805Z",
      likes: 5,
      comments: 10
    },
    {
      id: 8,
      text: "Graphing Calculator for Computer Science Major.",
      tags: ["multiple", "math", "course", "njit", "exam", "time"],
      createdAt: "2018-08-05T19:25:45.805Z",
      likes: 5,
      comments: 10
    },
    {
      id: 9,
      text: "What are the office hours for MATH 211-002 with professor Smith?",
      tags: ["multiple", "math", "njit", "final", "exam", "time"],
      createdAt: "2018-08-05T19:25:45.805Z",
      likes: 5,
      comments: 10
    }
  ]);
}

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
