<template>
  <v-container fluid fill-height>
    <v-layout align-center justify-center>
      <v-flex xs12 sm8 md5>
        <v-card class="elevation-12">
          <v-toolbar dark color="primary">
            <v-toolbar-title>Register</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <div class="errorMessage" v-if="submissionErrors.length > 0">{{ submissionErrors[0] }}</div>
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
                v-model.trim.lazy="password"
                prepend-icon="lock"
                name="password"
                label="Password"
                type="password"
                :error-messages="passErrors"
                @input="$v.password.$touch()"
                @blur="$v.password.$touch()"
                required
              ></v-text-field>
              <v-text-field
                v-model.trim.lazy="passConfirm"
                prepend-icon="lock"
                name="passwordConf"
                label="Password Confirmation"
                type="password"
                :error-messages="passConfirmErrors"
                @input="$v.passConfirm.$touch()"
                @blur="$v.passConfirm.$touch()"
                required
              ></v-text-field>
              <v-textarea
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
              ></v-textarea>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" :disabled="$v.$invalid" @click="onSubmit">Register</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<style>
.errorMessage {
  color: #ff0000;
  height: 2rem;
  font-size: 1.2rem;
}
</style>

<script>
import { validationMixin } from "vuelidate";
import {
  email,
  minLength,
  maxLength,
  required,
  sameAs
} from "vuelidate/lib/validators";
import { getSubmissionErrors } from "@/utils/FormUtils";

export default {
  mixins: [validationMixin],

  validations: {
    email: { required, email },
    password: { required, minLength: minLength(8), maxLength: maxLength(60) },
    passConfirm: { required, sameAsPassword: sameAs("password") },
    firstName: { required },
    lastName: { required },
    bio: { required }
  },

  data() {
    return {
      firstName: "",
      lastName: "",
      email: "",
      password: "",
      passConfirm: "",
      bio: "",
      submission: { errors: null }
    };
  },

  computed: {
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

    passErrors() {
      const errors = [];
      const { password } = this.$v;

      if (!password.$dirty) {
        return errors;
      }
      if (!password.required) {
        errors.push(`Password is required.`);
      }
      if (!password.minLength || !password.maxLength) {
        const { minLength, maxLength } = password.$params;
        errors.push(
          `Password must be between ${minLength.min} and ${
            maxLength.max
          } characters long.`
        );
      }

      return errors;
    },

    passConfirmErrors() {
      const errors = [];
      const { passConfirm } = this.$v;

      if (!passConfirm.$dirty) {
        return errors;
      }
      if (!passConfirm.required) {
        errors.push(`Password confirmation is required.`);
      }
      if (!passConfirm.sameAsPassword) {
        errors.push(`Passwords must match.`);
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
        errors.push(`Bio is required.`);
      }

      return errors;
    },

    submissionErrors() {
      const { errors } = this.submission;

      return Array.isArray(errors) ? errors : [];
    }
  },
  methods: {
    onSubmit: function() {
      const { firstName, lastName, email, password, bio } = this;

      if (this.$v.$invalid) return;

      // cleanup any previous submission errors
      this.resetSubmissionErrors();

      const handleSuccess = response => {
        this.$router.push({ path: "/login" });
      };

      const handleError = error => {
        this.submission = { errors: getSubmissionErrors(error) };
      };

      axios
        .post("api/register", {
          email,
          password,
          firstName,
          lastName,
          bio
        })
        .then(handleSuccess)
        .catch(handleError);
    },

    resetSubmissionErrors() {
      this.submission = { errors: null };
    }
  }
};
</script>
