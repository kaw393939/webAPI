<template>
  <v-app id="inspire">
    <v-content style="padding: 0;">
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12" style="width: 35rem;">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Register</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <div style="color: #ff0000; height: 2rem; font-size: 1.2rem;">{{error}}</div>
                <v-form>
                  <v-text-field
                    prepend-icon="person"
                    name="name"
                    label="Name"
                    type="text"
                    :error-messages="nameErrors"
                    required
                    @blur="$v.name.$touch()"
                    @input="onNameChange"
                  ></v-text-field>
                  <v-text-field
                    prepend-icon="mail"
                    name="email"
                    label="Email"
                    type="text"
                    :error-messages="emailErrors"
                    required
                    @blur="$v.email.$touch()"
                    @input="onEmailChange"
                  ></v-text-field>
                  <v-text-field
                    prepend-icon="lock"
                    name="password"
                    label="Password"
                    type="password"
                    :error-messages="passErrors"
                    required
                    @blur="$v.password.$touch()"
                    @input="onPassChange"
                  ></v-text-field>
                  <v-text-field
                    prepend-icon="lock"
                    name="passwordConf"
                    label="Password Confirm"
                    type="password"
                    :error-messages="passConfirmErrors"
                    required
                    @blur="$v.passConfirm.$touch()"
                    @input="onPassConfirmChange"
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
    </v-content>
  </v-app>
</template>


<script>
import { mapActions, mapGetters } from "vuex";
import { validationMixin } from "vuelidate";
import {
  required,
  maxLength,
  minLength,
  email,
  sameAs
} from "vuelidate/lib/validators";

export default {
  mixins: [validationMixin],

  validations: {
    name: { required, maxLength: maxLength(10) },
    email: { required, email },
    password: { required, minLength: minLength(6) },
    passConfirm: { required, sameAsPassword: sameAs("password") }
  },
  data: function() {
    return {
      name: "",
      email: "",
      password: "",
      passConfirm: ""
    };
  },
  computed: {
    ...mapGetters(["error"]),
    nameErrors() {
      const errors = [];
      if (!this.$v.name.$dirty) return errors;
      !this.$v.name.maxLength &&
        errors.push("Name must be at most 10 characters long");
      !this.$v.name.required && errors.push("Name is required.");
      return errors;
    },
    emailErrors() {
      const errors = [];
      if (!this.$v.email.$dirty) return errors;
      !this.$v.email.email && errors.push("Must be valid e-mail");
      !this.$v.email.required && errors.push("E-mail is required");
      return errors;
    },
    passErrors() {
      const errors = [];
      console.log(this.$v);
      if (!this.$v.password.$dirty) return errors;
      !this.$v.password.required && errors.push("Password is required");
      !this.$v.password.minLength &&
        errors.push("Password must be at least 6 characters long");
      return errors;
    },
    passConfirmErrors() {
      const errors = [];
      if (!this.$v.passConfirm.$dirty) return errors;
      !this.$v.passConfirm.required &&
        errors.push("Password confirmation is required");
      !this.$v.passConfirm.sameAsPassword &&
        errors.push("Passwords must match");
      return errors;
    }
  },
  methods: {
    ...mapActions(["signUp"]),
    onNameChange: function(event) {
      this.name = event;

      this.$emit("textChange", event);
    },
    onEmailChange: function(event) {
      this.email = event;

      this.$emit("textChange", event);
    },
    onPassChange: function(event) {
      this.password = event;

      this.$emit("textChange", event);
    },
    onPassConfirmChange: function(event) {
      this.passConfirm = event;

      this.$emit("textChange", event);
    },
    onSubmit: function() {
      if (!this.$v.$invalid) {
        this.signUp({
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.passConfirm
        });
      }
    },
    clear() {
      this.$v.$reset();
      this.name = "";
      this.email = "";
    }
  }
};
</script>