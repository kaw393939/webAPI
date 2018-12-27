<template>
  <v-container fixed fill-height>
    <v-layout align-center justify-center>
      <v-flex xs12 sm10 md8 lg6>
        <v-card class="elevation-12">
          <v-toolbar dark color="primary">
            <v-toolbar-title>Update Profile</v-toolbar-title>
            <v-spacer></v-spacer>
          </v-toolbar>
          <v-card-text>
            <v-form>
              <v-text-field
                v-model.trim.lazy="firstName"
                prepend-icon="account_circle"
                name="firstName"
                label="First Name"
                type="text"
                :error-messages="firstNameErrors"
                @input="$v.firstName.$touch()"
                @blur="$v.firstName.$touch()"
                required
              ></v-text-field>
              <v-text-field
                v-model.trim.lazy="lastName"
                prepend-icon="account_circle"
                name="lastName"
                label="Last Name"
                type="text"
                :error-messages="lastNameErrors"
                @input="$v.lastName.$touch()"
                @blur="$v.lastName.$touch()"
                required
              ></v-text-field>
              <v-text-field
                      v-model.trim.lazy="email"
                      prepend-icon="mail"
                      name="email"
                      label="Email"
                      type="email"
                      :error-messages="emailErrors"
                      @input="$v.email.$touch()"
                      @blur="$v.email.$touch()"
                      required
              ></v-text-field>
              <v-text-field
                      v-model.trim.lazy="bio"
                      name="bio"
                      value
                      prepend-icon="assignment"
                      placeholder="Enter your bio here..."
                      rows="3"
                      :error-messages="bioErrors"
                      @input="$v.bio.$touch()"
                      @blur="$v.bio.$touch()"
                      no-resize
                      counter
                      required
                      clearable
              ></v-text-field>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <p
              v-if="submissionFailure"
              class="subheading text-truncate errorMessage"
            >{{ submissionError }}</p>
            <p
              v-if="submissionSuccess"
              class="subheading text-truncate successMessage"
            >Successful submission!</p>
            <v-spacer></v-spacer>
            <v-btn @click="submit" color="primary">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<style>
.errorMessage {
  color: red;
}

.successMessage {
  color: green;
}
</style>


<script>
import get from "lodash/get";
import { mapGetters } from "vuex";
import { validationMixin } from "vuelidate";
import {
  maxLength,
  minLength,
  required,
  email,
  sameAs
} from "vuelidate/lib/validators";
import { getSubmissionErrors } from "@/utils/FormUtils";

export default {
  mixins: [validationMixin],

  data() {
    return {
      id: "",
      firstName: "",
      lastName: "",
      email: "",
      bio: "",
      submission: {
        errors: [],
        success: false
      }
    };
  },

  created() {
    const { id } = this.$route.params;

    const handleResponse = response => {
      const userInfo = get(response, "data", {});

      this.id = userInfo.id;
      this.firstName = userInfo.first_name;
      this.lastName = userInfo.last_name;
      this.email = userInfo.email;
      this.bio = userInfo.bio;
    };

    const handleError = error => {
      // this.error = true;
    };

    axios
      .get(`/api/profiles/${id}`)
      .then(handleResponse)
      .catch(handleError);
  },

  validations: {
    firstName: { required },
    lastName: { required },
    email: {
      required,
      email
    },
    bio: { required }
  },

  computed: {
    ...mapGetters["authUser"],

    firstNameErrors() {
      const errors = [];
      const { firstName } = this.$v;

      if (!firstName.$dirty) {
        return errors;
      }
      if (!firstName.required) {
        errors.push(`First name is required.`);
      }

      return errors;
    },

    lastNameErrors() {
      const errors = [];
      const { lastName } = this.$v;

      if (!lastName.$dirty) {
        return errors;
      }
      if (!lastName.required) {
        errors.push(`Last name is required.`);
      }

      return errors;
    },

    emailErrors() {
      const errors = [];
      const { email } = this.$v;

      if (!email.$dirty) {
        return errors;
      }
      if (!email.email) {
        errors.push(`Must be a valid email.`);
      }
      if (!email.required) {
        errors.push(`Email is required.`);
      }

      return errors;
    },

    bioErrors() {
      const errors = [];

      const { bio } = this.$v;

      if (!bio.$dirty) {
        return errors;
      }
      if (!bio.required) {
        errors.push("Bio is required.");
      }

      return errors;
    },

    submissionFailure() {
      return this.submission.errors.length > 0;
    },

    submissionError() {
      return this.submission.errors[0];
    },

    submissionSuccess() {
      return this.submission.success;
    }
  },

  methods: {
    submit() {
      this.$v.$touch();

      const { id } = this.$route.params;

      const submitForm = !this.$v.$invalid;

      if (!submitForm) return;

      const { name, email, bio } = this;

      const handleError = error => {
        this.resetSubmissionErrors();

        this.submission = {
          success: false,
          errors: getSubmissionErrors(error)
        };
      };

      const handleSuccessfulSubmission = response => {
        this.resetSubmissionErrors();

        this.$router.push({
          path: `/profile/${id}`
        });
      };

      axios
        .put(`/api/profiles/${id}`, {
          id,
          email: this.email,
          first_name: this.firstName,
          last_name: this.lastName,
          bio: this.bio
        })
        .then(handleSuccessfulSubmission)
        .catch(handleError);
    },

    resetSubmissionErrors() {
      this.submission = {
        errors: [],
        success: false
      };
    }
  }
};
</script>
