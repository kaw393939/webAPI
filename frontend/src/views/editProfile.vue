<template>
    <!--<v-app id="inspire">-->
        <v-content class="main">
            <v-container fixed fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4 class="xs12">
                        <v-card class="elevation-12">
                            <v-toolbar dark color="primary">
                                <v-toolbar-title>Update Profile</v-toolbar-title>
                                <v-spacer></v-spacer>
                            </v-toolbar>
                            <v-card-text>
                                <v-form>
                                    <v-text-field
                                            v-model="name"
                                            :error-messages="nameErrors"
                                            prepend-icon="person"
                                            label="Name"
                                            type="text"
                                            @input="$v.name.$touch()"
                                            @blur="$v.name.$touch()"
                                            required
                                    ></v-text-field>
                                    <v-text-field
                                            v-model="email"
                                            :error-messages="emailErrors"
                                            prepend-icon="email"
                                            label="Email"
                                            type="email"
                                            @input="$v.email.$touch()"
                                            @blur="$v.email.$touch()"
                                            required
                                    ></v-text-field>
                                    <v-text-field
                                            v-model="bio"
                                            :error-messages="bioErrors"
                                            prepend-icon="find_in_page"
                                            label="Description.."
                                            type="text"
                                            @input="$v.bio.$touch()"
                                            @blur="$v.bio.$touch()"
                                            required
                                    ></v-text-field>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <p
                                        v-if="submissionFailure"
                                        class="subheading text-truncate errorMessage"
                                >
                                    {{ submissionError }}
                                </p>
                                <p
                                        v-if="submissionSuccess"
                                        class="subheading text-truncate successMessage"
                                >
                                    Successful submission!
                                </p>
                                <v-spacer></v-spacer>
                                <v-btn @click="submit" color="primary">Save</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    <!--</v-app>-->
</template>

<style>
.errorMessage {
    color: red;
}

.main {
    padding: 64px 0px 0px 30px !important;
}

.xs12 {
    flex-basis: 50% !important;
    max-width: 50% !important;
}

.successMessage {
    color: green;
}
</style>


<script>
import { validationMixin } from "vuelidate";
import {
    maxLength,
    minLength,
    required,
    email,
    sameAs
} from "vuelidate/lib/validators";

const StatusCode = {
    "422": 422
};

export default {
    mixins: [validationMixin],

    data() {
        return {
            name: "",
            email: "",
            bio: "",
            submission: {
                errors: [],
                success: false
            }
        };
    },

    validations: {
        name: { required, minLength: minLength(2) },
        email: { required, email },
        bio: { required, minLength: minLength(5), maxLength: maxLength(50) }
    },

    computed: {
        nameErrors() {
            const errors = [];
            const name = this.$v.name;

            if (!name.$dirty) return errors;

            if (!name.minLength) {
                const { minLength } = name.$params;
                errors.push(
                    `Name must be at least ${minLength.min} characters long.`
                );
            }

            if (!name.required) {
                errors.push("Name is required.");
            }

            return errors;
        },

        emailErrors() {
            const errors = [];
            if (!this.$v.email.$dirty) return errors;
            !this.$v.email.email && errors.push("Must be a valid email");
            !this.$v.email.required && errors.push("Email is required");
            return errors;
        },

        bioErrors() {
            const errors = [];

            const { bio } = this.$v;

            if (!bio.$dirty) return errors;

            if (!bio.minLength || !bio.maxLength) {
                const { minLength, maxLength } = bio.$params;
                errors.push(
                    `Description must be between ${minLength.min} and ${
                        maxLength.max
                    } characters long.`
                );
            }

            if (!bio.required) {
                errors.push("Description is required.");
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
            // trigger touch on all fields to show errors if existent
            this.$v.$touch();

            const submitForm = !this.$v.$invalid;

            if (submitForm) {
                const { name, email, bio } = this;

                axios
                    .post("api/edit-profile", {
                        name,
                        email,
                        bio
                    })
                    .then(result => {
                        // cleanup if needed
                        if (this.submission.errors.length > 0) {
                            this.submission.errors = [];
                        }

                        this.submission.success = true;
                    })

                    .catch(err => {
                        const { response } = err;

                        // cleanup if needed
                        if (this.submission.success) {
                            this.submission.success = false;
                        }

                        if (response.status === StatusCode["422"]) {
                            // validation error
                            const { errors } = response.data;

                            const errorsArray = Object.values(errors).map(
                                error => error.pop()
                            );

                            this.submission.errors = errorsArray;
                        }
                    });
            }
        }
    }
};
</script>
