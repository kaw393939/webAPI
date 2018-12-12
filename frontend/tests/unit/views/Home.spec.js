import { shallowMount } from "@vue/test-utils";
import Vue from "vue";
import Vuetify from "vuetify";
import Home from "@/views/Home.vue";
import Card from "@/components/Card";
import CardHeader from "@/components/CardHeader";
import CardFooter from "@/components/CardFooter";
import PageHeading from "@/components/PageHeading";

describe("Home", () => {
    let wrapper;

    beforeEach(() => {
        Vue.use(Vuetify);
        wrapper = shallowMount(Home, {
            stubs: {
                card: Card,
                "card-header": CardHeader,
                "card-footer": CardFooter,
                "page-heading": PageHeading
            }
        });
        jest.mock("axios");
    });

    test("is a Vue instance", () => {
        const expected = true;
        const actual = wrapper.isVueInstance();

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
});
