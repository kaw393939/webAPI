import { mount } from "@vue/test-utils";
import App from "./App.vue";

describe("App", () => {
  test("is a Vue instance", () => {
    const wrapper = mount(App);
    const expected = true;
    const actual = wrapper.isVueInstance();

    expect(actual).toBe(expected);
  });
});
