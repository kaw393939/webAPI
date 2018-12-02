<template>
  <v-layout align-center justify-center>
    <v-flex xs12 sm8 md5>
      <v-card class="elevation-12">
        <v-toolbar dark color="primary">
          <v-toolbar-title>Login</v-toolbar-title>
        </v-toolbar>
        <v-card-text>
          <div class=".errorMessage">{{error}}</div>
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
</template>

<style>
.errorMessage {
  color: #ff0000;
  height: 2rem;
  font-size: 1.2rem;
}
</style>

<script>
import { mapActions, mapGetters } from "vuex";
import { validationMixin } from "vuelidate";
import { required, email } from "vuelidate/lib/validators";

export default {
  mixins: [validationMixin],

  validations: {
    email: { required, email },
    password: { required }
  },

  data() {
    return {
      email: "",
      password: ""
    };
  },

  computed: {
    ...mapGetters(["error"]),

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

      return errors;
    }
  },
  methods: {
    ...mapActions(["login"]),

    onSubmit: function() {
      const { email, password } = this;

      if (this.$v.$invalid) {
        return;
      }

      this.login({
        email,
        password
      });
    },

    clear() {
      this.$v.$reset();
      this.name = "";
      this.email = "";
    }
  }
};
</script>