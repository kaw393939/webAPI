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
                                    <v-form>
                                        <v-text-field prepend-icon="person" name="name" label="Name" type="text"  @input="onNameChange" ></v-text-field>
                                        <v-text-field prepend-icon="mail" name="email" label="Email" type="text"  @input="onEmailChange" ></v-text-field>
                                        <v-text-field prepend-icon="lock" name="password" label="Password" id="password" type="password" @input="onPassChange"></v-text-field>
                                        <v-text-field prepend-icon="lock" name="passwordConf" label="Password Confirm" type="password"  @input="onPassConfirmChange" ></v-text-field>
                                    </v-form>
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn color="primary" @click="onSubmit">Register</v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-content>
        </v-app>
</template>


<script>
    import {mapActions} from "vuex";
    export default {
        data: {
            name: '',
            email: '',
            pass: '',
            passConfirm: ''
        },
        methods: {
            ...mapActions(['signUp']),
            onNameChange: function(event){
                this.name = event;

                this.$emit("textChange", event);
            },
            onEmailChange: function(event) {
                this.email = event;

                this.$emit("textChange", event);
            },
            onPassChange: function(event){
                this.pass = event;

                this.$emit("textChange", event);
            },
            onPassConfirmChange: function(event){
                this.passConfirm = event;

                this.$emit("textChange", event);
            },
            onSubmit: function(){
                console.log(this.email, this.pass);
                this.signUp({
                    name: this.name,
                    email: this.email,
                    password: this.pass,
                    password_confirmation: this.passConfirm
                });
            }
        }};
</script>
