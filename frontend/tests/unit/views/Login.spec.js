import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuetify from "vuetify";
import Login from "@/views/Login.vue";

describe("Login", () => {
    let wrapper;

    beforeEach(() => {
        Vue.use(Vuetify);
        Vue.config.silent = true;

        wrapper = mount(Login);
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
        const expected = 2;
        const actual = wrapper.findAll(".v-text-field").length;

        expect(actual).toBe(expected);
    });

    test("it renders a submit button", () => {
        const expected = true;
        const actual = wrapper.find(".v-btn").exists();

        expect(actual).toBe(expected);
    });
});
