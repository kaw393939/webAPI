import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuetify from "vuetify";
import Question from "@/views/Question.vue";
import PageHeading from "@/components/PageHeading.vue";

describe("Question", () => {
    let wrapper;

    const $route = {
        path: "/question/1",
        params: { id: 1 }
    };

    beforeEach(() => {
        Vue.use(Vuetify);
        wrapper = mount(Question, {
            mocks: { $route }
        });
    });

    test("is a Vue instance", () => {
        const expected = true;
        const actual = wrapper.isVueInstance();

        expect(actual).toBe(expected);
    });

    test("renders a `PageHeading` component", () => {
        const expected = true;
        const actual = wrapper.contains(PageHeading);

        expect(actual).toBe(expected);
    });
});
