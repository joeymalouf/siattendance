export function statusCodeHandler(statusCode) {
    var message = "";
    switch (statusCode) {
        case 400:
            message = "Bad Request. Data was not valid. "
            break
        case 404:
            message = "404 Not Found. "
            break
        case 409:
            message = "409 Conflict. "
            break
        default:
            message = "An unknown error occured. "
            break
    }
    return message;
} 