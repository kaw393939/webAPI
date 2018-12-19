import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuetify from "vuetify";
import UserProfileEdit from "@/views/UserProfileEdit.vue";

describe("UserProfileEdit", () => {
    let wrapper;

    beforeEach(() => {
        Vue.use(Vuetify);
        Vue.config.silent = true;
        wrapper = mount(UserProfileEdit);
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

    test("renders 3 form elements", () => {
        const expected = 3;
        const actual = wrapper.findAll(".v-text-field").length;

        expect(actual).toBe(expected);
    });

    test("renders a submission button", () => {
        const expected = true;
        const actual = wrapper.find(".v-btn").exists();

        expect(actual).toBe(expected);
    });

    // test("should render a paragraph element to display form acceptance/rejection", () => {
    //     const expected = true;
    //     const actual = wrapper.find("p").exists();
    //     expect(actual).toBe(expected);
    // });
});
