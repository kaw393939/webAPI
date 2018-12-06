import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuetify from "vuetify";
import Home, { withDateFormatted } from "@/views/Home.vue";

describe("Home", () => {
    let wrapper;

    beforeEach(() => {
        Vue.use(Vuetify);
        wrapper = mount(Home);
        jest.mock("axios");
    });

    test("is a Vue instance", () => {
        const expected = true;
        const actual = wrapper.isVueInstance();

        expect(actual).toBe(expected);
    });

    test("renders a heading", () => {
        const expected = true;
        const actual = wrapper.contains("h2");

        expect(actual).toBe(expected);
    });

    test("fetches a list of questions", done => {
        wrapper.vm.$nextTick(() => {
            const expected = true;
            const actual = wrapper.vm.questions.length > 0;
            expect(actual).toBe(expected);
            done();
        });
    });

    test("withDateFormatted utility function should return items with formatted date", () => {
        const items = [
            {
                id: 1,
                text: "How hard are the math courses at NJIT?",
                tags: ["math", "course", "njit"],
                createdAt: "2018-08-05T19:25:45.805Z",
                likes: 5,
                comments: 10
            },
            {
                id: 2,
                text: "What is the Math Placement Exam?",
                tags: ["multiple", "math"],
                createdAt: "2018-08-05T19:25:45.805Z",
                likes: 5,
                comments: 10
            }
        ];
        const expected = items.length;
        const actual = withDateFormatted(items).map(
            ({ createdAtFormatted }) => createdAtFormatted
        ).length;

        expect(actual).toBe(expected);
    });
});
