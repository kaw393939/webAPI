import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuetify from "vuetify";
import editProfile from "./../../../src/views/editProfile.vue";

describe("editProfile", () => {
    let wrapper;

    beforeEach(() => {
        Vue.use(Vuetify);
        wrapper = mount(editProfile);
    });

    test("is a Vue instance", () => {
        const expected = true;
        const actual = wrapper.isVueInstance();

        expect(actual).toBe(expected);
    });

    test("should render a form element", () => {
        const expected = true;
        const actual = wrapper.find("v-form").exists();

        expect(actual).toBe(expected);
    });

    test("should render a form submitting button", () => {
        const expected = true;
        const actual = wrapper.find("v-btn").exists();

        expect(actual).toBe(expected);
    });

    test("should render a paragraph element to display form acceptance/rejection", () => {
        const expected = true;
        const actual = wrapper.find("p").exists();
        expect(actual).toBe(expected);
    });
});