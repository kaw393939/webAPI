import get from "lodash/get";
import isError from "lodash/isError";

export function getSubmissionErrors(error) {
    if (!isError(error)) {
        throw TypeError(`Argument must be of type 'Error'`);
    }

    const StatusCode = {
        BAD_REQUEST: 400,
        FORBIDDEN: 403,
        METHOD_NOT_ALLOWED: 405,
        UNAUTHORIZED: 401,
        UNPROCESSABLE_ENTITY: 422
    };

    const response = get(error, "response", null);

    const isValidationError =
        response && response.status === StatusCode.UNPROCESSABLE_ENTITY;
    if (isValidationError) {
        // handle Laravel validation errors
        const { errors } = get(response, "data", {});

        console.log("response", response);

        const validationErrors = errors
            ? Object.values(errors).map(error => error.pop())
            : ["Invalid parameters"];

        return validationErrors;
    }

    const isNotAuthorized =
        (response && response.status === StatusCode.FORBIDDEN) ||
        (response && response.status === StatusCode.UNAUTHORIZED);
    if (isNotAuthorized) {
        const errorMessage = ["You are not authorized to make this request."];

        return errorMessage;
    }

    const errorMessage = ["Something went wrong. Please try again."];

    return errorMessage;
}
