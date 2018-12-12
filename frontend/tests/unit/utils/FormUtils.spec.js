import { getSubmissionErrors } from "@/utils/FormUtils";

function createError(status, options = {}) {
    const err = new Error();

    return Object.assign(err, {
        response: { status },
        isAxiosError: true,
        ...options
    });
}

describe("FormUtils", () => {
    describe("getSubmissionErrors", () => {
        test("should throw when invalid input is passed", () => {
            expect(() => {
                getSubmissionErrors("invalid");
            }).toThrow();
        });

        test("should return an error related to FORBIDDEN status code", () => {
            const FORBIDDEN = 403;

            const error = createError(FORBIDDEN);
            const responseErrors = getSubmissionErrors(error);

            const expected = "You are not authorized to make this request.";
            const actual = responseErrors.pop();

            expect(actual).toBe(expected);
        });

        test("should return an error related to UNAUTHORIZED status code", () => {
            const UNAUTHORIZED = 401;

            const error = createError(UNAUTHORIZED);
            const responseErrors = getSubmissionErrors(error);

            const expected = "You are not authorized to make this request.";
            const actual = responseErrors.pop();

            expect(actual).toBe(expected);
        });

        test("should return errors related to Laravel validation errors", () => {
            const UNPROCESSABLE_ENTITY = 422;

            const error = createError(UNPROCESSABLE_ENTITY, {
                response: {
                    status: UNPROCESSABLE_ENTITY,
                    data: {
                        errors: {
                            email: ["Email has already been taken."],
                            password: [
                                "Password should be at least 8 characters long."
                            ]
                        }
                    }
                }
            });
            const responseErrors = getSubmissionErrors(error);

            const expected = 2;
            const actual = responseErrors.length;

            expect(actual).toBe(expected);
        });

        test("should return a generic error", () => {
            const BAD_REQUEST = 400;

            const error = createError(BAD_REQUEST);
            const responseErrors = getSubmissionErrors(error);

            const expected = "Something went wrong. Please try again.";
            const actual = responseErrors.pop();

            expect(actual).toBe(expected);
        });
    });
});
