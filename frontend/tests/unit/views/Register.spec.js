import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuetify from "vuetify";
import Register from "@/views/Register.vue";

describe("Register", () => {
    let wrapper;

    beforeEach(() => {
        Vue.use(Vuetify);
        Vue.config.silent = true;
        wrapper = mount(Register);
    });

    test("is a Vue instance", () => {
        const expected = true;
        const actual = wrapper.isVueInstance();

        expect(actual).toBe(expected);
    });

    test("it renders a form", () => {
        const expected = true;
        const actual = wrapper.find(".v-form").exists();

        expect(actual).toBe(expected);
    });

    test("it renders input fields", () => {
        const expected = 6;
        const actual = wrapper.findAll(".v-text-field").length;

        expect(actual).toBe(expected);
    });

    test("it renders a textarea field", () => {
        const expected = true;
        const actual = wrapper.find(".v-textarea").exists();

        expect(actual).toBe(expected);
    });
});
