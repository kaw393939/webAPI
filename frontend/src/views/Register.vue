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
                v-model.trim.lazy="email"
                prepend-icon="mail"
                name="email"
                label="Email"
                type="text"
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
import { email, minLength, required, sameAs } from "vuelidate/lib/validators";
import { getSubmissionErrors } from "@/utils/FormUtils";

export default {
  mixins: [validationMixin],

  validations: {
    email: { required, email },
    password: { required, minLength: minLength(6) },
    passConfirm: { required, sameAsPassword: sameAs("password") }
  },

  data() {
    return {
      email: "",
      password: "",
      passConfirm: "",
      submission: { errors: null }
    };
  },

  computed: {
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
      if (!password.minLength) {
        const { min } = password.$params.minLength;
        errors.push(`Password must be at least ${min} characters long.`);
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

    submissionErrors() {
      const { errors } = this.submission;

      return Array.isArray(errors) ? errors : [];
    }
  },
  methods: {
    onSubmit: function() {
      const { email, password } = this;

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
        .post("api/register", { email, password })
        .then(handleSuccess)
        .catch(handleError);
    },

    resetSubmissionErrors() {
      this.submission = { errors: null };
    }
  }
};
</script>
