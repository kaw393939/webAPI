<template>
  <v-container fluid>
    <template v-if="questionDidFetch">
      <page-heading>Answer Question</page-heading>
      <v-layout justify-center row wrap>
        <card classes="card">
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
        </card>
      </v-layout>

      <page-heading>Your Answer</page-heading>

      <v-layout justify-center row wrap>
        <v-flex xs8>
          <v-form>
            <v-textarea
              v-model.trim.lazy="answer"
              name="answer"
              label="Answer"
              hint="Type your answer here..."
              :error-messages="answerErrors"
              @input="$v.answer.$touch()"
              @blur="$v.answer.$touch()"
              counter
              clearable
              outline
              auto-grow
              value
              required
            ></v-textarea>
          </v-form>
        </v-flex>
      </v-layout>
      <v-layout justify-center row>
        <div class="submissionErrorMessage" v-if="submissionErrors.length > 0">
          <h4 class="title">{{ submissionErrors[0] }}</h4>
        </div>
      </v-layout>
      <v-layout justify-center row wrap>
        <v-btn @click="submitAnswer" color="primary" :disabled="disableSubmission">Submit</v-btn>
      </v-layout>
    </template>

    <template v-if="!isLoading && error">
      <div class="messageWrapper">
        <h3 class="message headline">Oops! Looks like were having some troubles. Try again.</h3>
      </div>
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

.messageWrapper {
  width: 100%;
  margin-top: 50px;
}
.message {
  text-align: center;
}
.submissionErrorMessage {
  color: #ff0000;
  text-align: center;
  margin: 10px 0;
}
</style>

<script>
import distanceInWordsToNow from "date-fns/distance_in_words_to_now";
import { validationMixin } from "vuelidate";
import { maxLength, minLength, required } from "vuelidate/lib/validators";
import isNil from "lodash/isNil";
import flow from "lodash/flow";
import get from "lodash/get";

import { getSubmissionErrors } from "../utils/FormUtils";
import Card from "../components/Card.vue";
import CardFooter from "../components/CardFooter.vue";
import CardHeader from "../components/CardHeader.vue";
import PageHeading from "../components/PageHeading.vue";

export default {
  components: {
    Card,
    CardFooter,
    CardHeader,
    PageHeading
  },

  mixins: [validationMixin],

  validations: {
    answer: {
      required,
      minLength: minLength(10),
      maxLength: maxLength(500)
    }
  },

  data() {
    return {
      answer: "",
      question: {},
      submission: {
        errors: null,
        success: false
      },
      error: false,
      isLoading: true
    };
  },

  created() {
    const { id } = this.$route.params;

    if (isNil(id)) return;

    const handleResponse = response => {
      const question = get(response, "data", {});

      const withFormattedDate = item => ({
        ...item,
        createdAtFormatted: `${distanceInWordsToNow(item.createdAt.date)} ago`
      });
      const withAuthorFullName = item => ({
        ...item,
        author: {
          ...item.author,
          fullName: `${item.author.firstName} ${item.author.lastName}`
        }
      });

      const withFormattedAttrs = flow([withFormattedDate, withAuthorFullName]);

      this.question = withFormattedAttrs(question);
      this.isLoading = false;
    };

    const handleError = error => {
      this.isLoading = false;
      this.error = true;
    };

    axios
      .get(`/api/questions/${id}`)
      .then(handleResponse)
      .catch(handleError);
  },

  computed: {
    answerErrors() {
      const errors = [];
      const { answer } = this.$v;

      if (!answer.$dirty) {
        return errors;
      }
      if (!answer.minLength || !answer.maxLength) {
        const { minLength, maxLength } = answer.$params;
        errors.push(
          `Answer must be between ${minLength.min} and ${
            maxLength.max
          } characters long.`
        );
      }
      if (!answer.required) {
        errors.push("Answer is required.");
      }

      return errors;
    },

    disableSubmission() {
      if (!this.$v.$dirty) {
        return true;
      }

      return this.$v.$dirty && this.$v.$invalid;
    },

    submissionErrors() {
      const { errors } = this.submission;

      return !isNil(errors) ? errors : [];
    },

    questionDidFetch() {
      return !this.isLoading && !this.error;
    }
  },

  methods: {
    submitAnswer() {
      this.$v.$touch();

      const submitForm = this.$v.$invalid;

      if (submitForm) return;

      const { id } = this.$route.params;

      const handleError = error => {
        this.resetSubmissionErrors();

        this.submission = {
          success: false,
          errors: getSubmissionErrors(error)
        };
      };

      const handleResponse = response => {
        this.$router.push({
          path: `/question/${id}`
        });
      };

      axios
        .post(`/api/questions/${id}/answers`, {
          answer: this.answer
        })
        .then(handleResponse)
        .catch(handleError);
    },

    resetSubmissionErrors() {
      this.submission = {
        errors: null,
        success: false
      };
    }
  }
};
</script>