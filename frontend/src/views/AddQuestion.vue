<template>
    <v-container grid-list-md text-xs-center>
        <v-layout row wrap>
            <v-layout align-center justify-center>
                <v-flex xs12 sm10 md8 lg8 xl4>
                    <!--<h2-->
                    <!--class="heading headline text-lg-center text-md-center text-sm-center text-xs-center"-->
                    <!--&gt;New Question</h2>-->
                    <page-heading>New Question</page-heading>
                    <v-spacer></v-spacer>
                    <v-form>
                        <v-text-field class="px-0"
                                      v-model="question"
                                      :error-messages="questionErrors"
                                      type="input"
                                      label="Question"
                                      placeholder="Type Question.."
                                      @input="$v.question.$touch()"
                                      @blur="$v.question.$touch()"
                                      box
                        ></v-text-field>
                        <v-textarea
                                      v-model="tag"
                                      :error-messages="tagErrors"
                                      type="input"
                                      label="Tags"
                                      placeholder="Type tags separated by commas"
                                      @input="$v.tag.$touch()"
                                      @blur="$v.tag.$touch()"
                                      box
                        ></v-textarea>
                        <v-btn @click="submitQuestion" color="primary">Submit</v-btn>
                    </v-form>
                </v-flex>
            </v-layout>
        </v-layout>
    </v-container>
</template>
<style>
    /*.xs{*/
        /*width: 50% !important;*/
    /*}*/
</style>

<script>
    import { validationMixin } from "vuelidate";
    import {
        maxLength,
        minLength,
        required,
        sameAs
    } from "vuelidate/lib/validators";
    import { getSubmissionErrors } from "@/utils/FormUtils";
    import PageHeading from "./../components/PageHeading.vue";

    export default {
        components: {
            PageHeading: PageHeading
        },

        mixins: [validationMixin],

        data() {
            return {
                question: "",
                tag: "",
                submission: {
                    errors: [],
                    success: false
                }
            };
        },

        validations: {
            question: {
                required,
                minLength: minLength(10),
                maxLength: maxLength(280)
            },
            tag: {
                required,
                minLength: minLength(5),
                maxLength: maxLength(100)
            },
        },

        computed: {
            questionErrors() {
                const errors = [];
                const { question } = this.$v;

                if (!question.$dirty) {
                    return errors;
                }
                if (!question.minLength) {
                    const { minLength } = question.$params;
                    errors.push(`Question must be at least ${minLength.min} characters long.`);
                }
                if(!question.maxLength){
                    const { maxLength } = question.$params;
                    errors.push(`Question must be less than ${maxLength.max} characters long.`);
                }
                if (!question.required) {
                    errors.push("Question is required.");
                }

                return errors;
            },

            tagErrors() {
                const errors = [];
                const { tag } = this.$v;

                if (!tag.$dirty) {
                    return errors;
                }
                if (!tag.minLength) {
                    const { minLength } = tag.$params;
                    errors.push(`Tag must be at least ${minLength.min} characters long.`);
                }
                if(!tag.maxLength){
                    const { maxLength } = tag.$params;
                    errors.push(`Tags must total less than ${maxLength.max} characters long.`);
                }
                if (!tag.required) {
                    errors.push("Tag is required.");
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
            submitQuestion() {
                this.$v.$touch();

                const submitForm = !this.$v.$invalid;

                if (!submitForm) return;

                const { question, tag } = this;

                const handleError = error => {
                    this.resetSubmissionErrors();

                    this.submission = {
                        success: false,
                        errors: getSubmissionErrors(error)
                    };
                };

                const handleSuccessfulSubmission = response => {
                    this.resetSubmissionErrors();
                    this.submission.success = true;
                };

                axios
                    .post("api/add-question", { question, tag })
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