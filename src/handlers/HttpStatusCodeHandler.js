export function statusCodeHandler(statusCode) {
    var message = "";
    switch(statusCode){
        case 400:
            message = "Bad Request. Data was not valid."
            break 
        case 404:
            message = "404 Not Found. The server could not find the requested resource."
            break
        default:
            message = "An unknown error occured"
            break
    }
    return message;
} 