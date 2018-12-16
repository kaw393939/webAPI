import isNil from "lodash/isNil";

const AUTH_TOKEN = "token";

export function getAuthToken() {
    try {
        const token = localStorage.getItem(AUTH_TOKEN);

        return !isNil(token) ? token : null;
    } catch (err) {
        return null;
    }
}

export function setAuthToken(token) {
    try {
        localStorage.setItem(AUTH_TOKEN, token);

        return token;
    } catch (err) {
        return err;
    }
}

export function removeAuthToken() {
    try {
        const token = localStorage.getItem(AUTH_TOKEN);
        localStorage.removeItem(AUTH_TOKEN);

        return token;
    } catch (err) {
        return err;
    }
}
