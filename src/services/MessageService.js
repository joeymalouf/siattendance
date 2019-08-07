
export class MessageService {

    constructor(vue) {
        this.vue = vue 
    }
    passErrorMessage(error) {
        this.vue.$emit("pass-error-message", error)
    }
    passSuccessMessage(success) {
        this.vue.$emit("pass-success-message", success)
    }

}
