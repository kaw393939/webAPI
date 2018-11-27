<!--<template>-->
  <!--<v-card-->
    <!--color="blue-grey darken-1"-->
    <!--dark-->
    <!--style="width: 50%; height: 95%; margin: 0 auto;"-->
  <!--&gt;-->
    <!--<v-layout wrap class="text-md-center display-1 font-weight-medium" style="padding: 2rem; display: flex; justify-content: center;" >-->
      <!--Login Page-->
    <!--</v-layout>-->

    <!--<v-layout wrap class="text-md-center title font-weight-regular" style="margin: 0 6rem 0 6rem; display: flex; justify-content: center;" >-->
      <!--Fill out the form below to login.-->
    <!--</v-layout>-->

    <!--<v-form style="padding: 2rem;">-->
      <!--<v-container>-->
        <!--<v-layout wrap>-->
          <!--<v-flex xs12 >-->
            <!--<v-text-field-->
              <!--v-model="Email"-->
              <!--:disabled="isUpdating"-->
              <!--box-->
              <!--color="blue-grey lighten-2"-->
              <!--label="Email"-->
              <!--required-->
              <!--@input="onEmailChange"-->
            <!--&gt;</v-text-field>-->
            <!--<v-text-field-->
              <!--v-model="password"-->
              <!--:append-icon="show1 ? 'visibility_off' : 'visibility'"-->
              <!--:errormessage="nameErrors"-->
              <!--box-->
              <!--color="blue-grey lighten-2"-->
              <!--label="Password"-->
              <!--hint="Atleast 6 characters"-->
              <!--required-->
              <!--@input="onPassChange"-->
              <!--@click:append="show1 = !show1"-->
            <!--&gt;</v-text-field>-->
          <!--</v-flex>-->

        <!--</v-layout>-->
      <!--</v-container>-->
      <!--<div style="width: 100%; display:flex; justify-content: center; align-items: center; ">-->
        <!--<v-btn large @click="onSubmit">Login</v-btn>-->
      <!--</div>-->
    <!--</v-form>-->
    <!--<v-divider></v-divider>-->
    <!--<div>-->

    <!--</div>-->
  <!--</v-card>-->
<!--</template>-->

<template>
<v-app id="inspire">
  <v-content style="padding: 0;">
    <v-container fluid fill-height>
      <v-layout align-center justify-center>
        <v-flex xs12 sm8 md4>
          <v-card class="elevation-12" style="width: 35rem;">
            <v-toolbar dark color="primary">
              <v-toolbar-title>Login</v-toolbar-title>
            </v-toolbar>
            <v-card-text>
              <div style="color: #ff0000; height: 2rem; font-size: 1.2rem;">{{error}}</div>
              <v-form>
                <v-text-field prepend-icon="mail" name="email" label="Email" type="text" :error-messages="emailErrors" required @blur="$v.email.$touch()"  @input="onEmailChange" ></v-text-field>
                <v-text-field prepend-icon="lock" name="password" label="Password" type="password" :error-messages="passErrors" required @blur="$v.password.$touch()" @input="onPassChange"></v-text-field>
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
  </v-content>
</v-app>
</template>

<script>
    import {mapActions, mapGetters} from "vuex";
    import { validationMixin } from 'vuelidate'
    import { required, email } from 'vuelidate/lib/validators'

  export default {
      mixins: [validationMixin],

      validations: {
          email: { required, email },
          password: { required },
      },
    data: function() {
      return {
        email: '',
        password: ''
      };
    },
    computed: {
      ...mapGetters(['error']),
      emailErrors () {
          const errors = []
          if (!this.$v.email.$dirty) return errors
          !this.$v.email.email && errors.push('Must be valid e-mail')
          !this.$v.email.required && errors.push('E-mail is required')
          return errors
      },
      passErrors () {
          const errors = []
          if (!this.$v.password.$dirty) return errors
          !this.$v.password.required && errors.push('Password is required')
          return errors;
      }
    },
    methods: {
      ...mapActions(['login']),
      onEmailChange: function(event) {
        this.email = event;

        this.$emit("textChange", event);
      },
      onPassChange: function(event){
        this.password = event;

        this.$emit("textChange", event);
      },
      onSubmit: function(){
        console.log(this.email, this.password);
          if(!this.$v.$invalid) {
            this.login({email: this.email, password: this.password});
          }
      },
      clear () {
          this.$v.$reset()
          this.name = ''
          this.email = ''
      }
    }
 }

</script>
