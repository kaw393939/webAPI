import faker from "faker";
import isNil from "lodash/isNil";
import { withFormattedDate } from "@/utils/ApiResponseUtils";

describe("ApiResponseUtils", () => {
    describe("withFormattedDate", () => {
        test("returns an object with a formatted date", () => {
            const item = {
                id: 1,
                createdAt: faker.date.past()
            };

            const result = withFormattedDate(item);
            const expected = false;
            const actual = isNil(result.createdAtFormatted);

            expect(actual).toBe(expected);
        });
    });
});
