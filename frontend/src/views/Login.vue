<template>
  <v-container fluid fill-height>
    <v-layout align-center justify-center>
      <v-flex xs12 sm8 md5>
        <v-card class="elevation-12">
          <v-toolbar dark color="primary">
            <v-toolbar-title>Login</v-toolbar-title>
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
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" :disabled="$v.$invalid" @click="onSubmit">Login</v-btn>
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
import { mapMutations } from "vuex";
import { validationMixin } from "vuelidate";
import { required, email, minLength } from "vuelidate/lib/validators";
import get from "lodash/get";
import { getSubmissionErrors } from "@/utils/FormUtils";
import { setAuthToken } from "@/utils/LocalStorageUtils";

export default {
  mixins: [validationMixin],

  validations: {
    email: { required, email },
    password: { required, minLength: minLength(8) }
  },

  data() {
    return {
      email: "",
      password: "",
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

    submissionErrors() {
      const { errors } = this.submission;

      return Array.isArray(errors) ? errors : [];
    }
  },

  methods: {
    ...mapMutations(["setAuthUser"]),

    onSubmit: function() {
      const { email, password } = this;

      if (this.$v.$invalid) return;

      // cleanup any previous submission errors
      this.resetSubmissionErrors();

      const handleSuccess = response => {
        const token = get(response, "data.token", null);

        if (!token) return;

        setAuthToken(token);
        axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;

        // move this getAuthUser when API route gets fixed
        this.setAuthUser({
          data: {
            id: 1,
            name: "John",
            email: "Doe"
          }
        });
        this.$router.push({ path: "/" });
      };

      const getAuthUser = () => {
        const handleGetAuthUserResponse = response => {
          const { id, name, email } = get(response, "data.user", {});

          this.setAuthUser({
            data: { id, name, email }
          });
        };

        return axios.get("api/user").then(handleGetAuthUserResponse);
      };

      const handleError = error => {
        this.submission = { errors: getSubmissionErrors(error) };
      };

      axios
        .post("api/login", { email, password })
        .then(handleSuccess)
        // .then(getAuthUser)
        .catch(handleError);
    },

    resetSubmissionErrors() {
      this.submission = { errors: null };
    }
  }
};
</script>
