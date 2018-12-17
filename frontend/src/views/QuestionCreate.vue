<template>
  <v-container fluid>
    <template v-if="!submission.success">
      <page-heading>Create New Question</page-heading>

      <v-layout align-center justify-center wrap class="formWrapper">
        <v-flex xs12 sm10 md8 lg8 xl4 class="errorWrapper">
          <h1
            class="title text-uppercase red--text errorMessage"
            v-show="submissionErrors.length > 0"
          >{{ submissionErrors[0] }}</h1>
        </v-flex>
        <v-flex xs12 sm10 md8 lg8 xl4>
          <v-form>
            <v-textarea
              v-model.trim.lazy="question"
              name="question"
              label="Question"
              hint="Type your question here..."
              :error-messages="questionErrors"
              @input="$v.question.$touch()"
              @blur="$v.question.$touch()"
              outline
              counter
              clearable
              auto-grow
              value
              required
            ></v-textarea>
          </v-form>
        </v-flex>
        <v-flex xs12 sm10 md8 lg8 xl4 justify-end class="buttonWrapper">
          <v-btn @click="handleOnSubmit" color="primary" :disabled="disableSubmission">Submit</v-btn>
        </v-flex>
      </v-layout>
    </template>

    <v-layout wrap class="feedbackContainer" v-if="submission.success">
      <v-flex xs12 justify-center class="displayFlex feedbackContainerRow">
        <v-icon x-large color="green">fa-check</v-icon>
      </v-flex>
      <v-flex xs12>
        <h2 class="headline centerText feedbackContainerRow">Your question was created successfully!</h2>
      </v-flex>
      <v-flex xs12 class="displayFlex" justify-center>
        <v-btn color="primary navButton" to="/">Home</v-btn>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<style scoped>
.centerText {
  text-align: center;
}
.displayFlex {
  display: flex;
}

.formWrapper {
  margin-top: 15px;
}
.errorWrapper {
  height: 50px;
}
.errorMessage {
  margin: 15px 0;
  text-align: center;
}
.buttonWrapper {
  margin-top: 25px;
  display: flex;
}

.feedbackContainer {
  margin-top: 45px;
}
.feedbackContainerRow {
  margin: 20px 0;
}
.navButton {
  margin: 20px 0;
}
</style>

<script>
import { validationMixin } from "vuelidate";
import { maxLength, minLength, required } from "vuelidate/lib/validators";
import isNil from "lodash/isNil";
import PageHeading from "./../components/PageHeading.vue";
import { getSubmissionErrors } from "@/utils/FormUtils";

export default {
  components: {
    PageHeading: PageHeading
  },

  mixins: [validationMixin],

  data() {
    return {
      question: "",
      submission: {
        errors: null,
        success: false
      }
    };
  },

  validations: {
    question: {
      required,
      minLength: minLength(10),
      maxLength: maxLength(500)
    }
  },

  computed: {
    questionErrors() {
      const errors = [];
      const { question } = this.$v;

      if (!question.$dirty) {
        return errors;
      }
      if (!question.minLength || !question.maxLength) {
        const { minLength, maxLength } = question.$params;
        errors.push(
          `Question must be between ${minLength.min} and ${
            maxLength.max
          } characters long.`
        );
      }
      if (!question.required) {
        errors.push("Question is required.");
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
    }
  },

  methods: {
    handleOnSubmit() {
      const preventFormSubmission = this.$v.$invalid;

      if (preventFormSubmission) return;

      this.resetSubmissionState();

      const handleResponse = response => {
        this.submission.errors = null;
        this.submission.success = true;
      };
      const handleError = error => {
        this.submission.errors = getSubmissionErrors(error);
      };

      axios
        .post("api/questions", { question: this.question })
        .then(handleResponse)
        .catch(handleError);
    },

    resetSubmissionState() {
      this.submission = {
        errors: null,
        success: false
      };
    }
  }
};
</script>