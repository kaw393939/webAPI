<template>
    <v-container grid-list-md text-xs-center>
        <page-heading>Answer Question</page-heading>
        <v-layout justify-center row wrap>
            <card classes="card">
                <card-header>
                    <v-flex xs6 class="cardHeader__left">
                        <span class="font-weight-regular font-italic">{{ question.createdAtFormatted }}</span>
                    </v-flex>
                    <v-flex xs6 class="cardHeader__right">
                        <v-btn icon color="blue-grey--text darken-1--text">
                            <v-icon>more_vert</v-icon>
                        </v-btn>
                    </v-flex>
                </card-header>

                <v-card-text>
                    <p class="title">{{ question.text }}</p>
                </v-card-text>

                <card-footer>
                    <template v-for="tag in question.tags">
                        <v-chip label outline small color="white" :key="tag.id">{{ tag }}</v-chip>
                    </template>
                </card-footer>
            </card>
        </v-layout>
        <v-layout justify-center row wrap>
            <v-flex xs8>
                <v-form>
                    <v-textarea
                            v-model.trim.lazy="answer"
                            name="answer"
                            label="Answer"
                            hint="Type your answer here..."
                            :error-messages="answerErrors"
                            @input="$v.answer.$touch()"
                            @blur="$v.answer.$touch()"
                            counter
                            clearable
                            outline
                            auto-grow
                            value
                            required
                    ></v-textarea>
                </v-form>
            </v-flex>
        </v-layout>
        <v-layout justify-center row wrap>
            <v-btn @click="submitAnswer" color="primary" :disabled="disableSubmission">Submit</v-btn>
        </v-layout>
    </v-container>
</template>

<script>
    import { validationMixin } from "vuelidate";
    import { maxLength, minLength, required } from "vuelidate/lib/validators";
    import isNil from "lodash/isNil";
    import { getSubmissionErrors } from "../utils/FormUtils";
    import Card from "../components/Card.vue";
    import CardFooter from "../components/CardFooter.vue";
    import CardHeader from "../components/CardHeader.vue";
    import PageHeading from "../components/PageHeading.vue";

    export default {
        components: {
            Card,
            CardFooter,
            CardHeader,
            PageHeading
        },

        mixins: [validationMixin],

        validations: {
            answer: {
                required,
                minLength: minLength(10),
                maxLength: maxLength(500)
            }
        },

        computed: {
            answerErrors() {
                const errors = [];
                const { answer } = this.$v;

                if (!answer.$dirty) {
                    return errors;
                }
                if (!answer.minLength || !answer.maxLength) {
                    const { minLength, maxLength } = answer.$params;
                    errors.push(
                        `Answer must be between ${minLength.min} and ${
                            maxLength.max
                            } characters long.`
                    );
                }
                if (!answer.required) {
                    errors.push("Answer is required.");
                }

                return errors;
            },

            disableSubmission() {
                if (!this.$v.$dirty) {
                    return true;
                }

                return this.$v.$dirty && this.$v.$invalid;
            },

            submissionErrors() {
                const { errors } = this.submission;

                return !isNil(errors) ? errors : [];
            }
        },

        methods: {
            submitAnswer() {
                this.$v.$touch();

                const submitForm = this.$v.$invalid;

                if (submitForm) return;

                const { answer } = this;

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
                    .post("api/question-answer", { answer })
                    .then(handleSuccessfulSubmission)
                    .catch(handleError);
            },

            resetSubmissionErrors() {
                this.submission = {
                    errors: null,
                    success: false
                };
            }
        },

        data(){
            return{
                answer: "",
                submission: {
                    errors: null,
                    success: false
                },
                question: {
                    text: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. In facilisis at tortor at maximus. Quisque dignissim ipsum neque, a aliquam diam consequat in. Fusce lacinia dictum risus",
                    createdAtFormatted: "PostedTime",
                    tags: ["NJIT", "faq", "question", "IS421"]
                }
            }
        }
    };
</script>