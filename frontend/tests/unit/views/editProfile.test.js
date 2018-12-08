import { mount } from "@vue/test-utils";
import Vue from "vue";
import Vuetify from "vuetify";
import EditProfile from "@/views/EditProfile.vue";

describe("EditProfile", () => {
    let wrapper;

    beforeEach(() => {
        Vue.use(Vuetify);
        wrapper = mount(EditProfile);
    });

    test("has a form submission function", () => {
        expect(typeof EditProfile.submit).toBe("function");
    });
});
