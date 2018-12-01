import { mount, createLocalVue } from "@vue/test-utils";
import Vuetify from "vuetify";
import Register from "../../src/views/Register.vue";

describe("App", () => {
    let wrapper;

    beforeEach(() => {
        const localVue = createLocalVue();
        localVue.use(Vuetify);

        wrapper = mount(Register, {
            localVue
        });
    });

    test("is a Vue instance", () => {
        const expected = true;
        const actual = wrapper.isVueInstance();

        expect(actual).toBe(expected);
    });
});
