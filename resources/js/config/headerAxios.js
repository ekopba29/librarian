import * as authHelper from "../helper/authHelper";

export const headersJsonBarier = () => {
    return {
        headers: {
            Accept: "application/json",
            Authorization: authHelper.getToken(),
        }
    }
};