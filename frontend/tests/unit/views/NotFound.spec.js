import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuetify from "vuetify";
import NotFound from "@/views/NotFound.vue";
import IconRobot from "@/components/icons/IconRobot.vue";

describe("NotFound", () => {
    let wrapper;

    beforeEach(() => {
        Vue.use(Vuetify);
        wrapper = mount(NotFound);
    });

    test("is a Vue instance", () => {
        const expected = true;
        const actual = wrapper.isVueInstance();

        expect(actual).toBe(expected);
    });

    test("should render an <icon-robot /> component", () => {
        const expected = true;
        const actual = wrapper.contains(IconRobot);

        expect(actual).toBe(expected);
    });

    test("should render a heading element", () => {
        const expected = true;
        const actual = wrapper.find("h2").exists();

        expect(actual).toBe(expected);
    });

    test("should render a paragraph element", () => {
        const expected = true;
        const actual = wrapper.find("p").exists();

        expect(actual).toBe(expected);
    });
});
