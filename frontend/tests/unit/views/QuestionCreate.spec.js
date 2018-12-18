import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuetify from "vuetify";
import QuestionCreate from "@/views/QuestionCreate.vue";

describe("QuestionCreate", () => {
    let wrapper;

    beforeEach(() => {
        Vue.use(Vuetify);
        wrapper = mount(QuestionCreate);
    });

    test("is a Vue instance", () => {
        const expected = true;
        const actual = wrapper.isVueInstance();

        expect(actual).toBe(expected);
    });

    test("renders a form", () => {
        const expected = true;
        const actual = wrapper.find(".v-form").exists();

        expect(actual).toBe(expected);
    });

    test("renders input field for question", () => {
        const expected = true;
        const actual = wrapper.find(".v-text-field").exists();

        expect(actual).toBe(expected);
    });

    test("renders a submission button", () => {
        const expected = true;
        const actual = wrapper.find(".v-btn").exists();

        expect(actual).toBe(expected);
    });

});