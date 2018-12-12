import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuetify from "vuetify";
import CardFooter from "@/components/CardFooter.vue";

describe("Card", () => {
    let wrapper;

    beforeEach(() => {
        Vue.use(Vuetify);
        wrapper = mount(CardFooter, {
            slots: {
                default: `<div class="test">Test Div</div>`
            }
        });
    });

    test("is a Vue instance", () => {
        const expected = true;
        const actual = wrapper.isVueInstance();

        expect(actual).toBe(expected);
    });

    test("should render a Test div element", () => {
        const expected = true;
        const actual = wrapper.find(".test").exists();

        expect(actual).toBe(expected);
    });

    test("should render a Test div element inside a footer component", () => {
        const layoutElement = wrapper.find(".footer");

        const expected = true;
        const actual = layoutElement.find(".test").exists();

        expect(actual).toBe(expected);
    });
});
