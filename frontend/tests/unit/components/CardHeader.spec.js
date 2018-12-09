import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuetify from "vuetify";
import CardHeader from "@/components/CardHeader.vue";

describe("Card", () => {
    let wrapper;

    beforeEach(() => {
        Vue.use(Vuetify);
        wrapper = mount(CardHeader, {
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
});
