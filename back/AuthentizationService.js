import MessageService from 'MessageService';

export default class AuthenticationService {

    checkRole() {
        var role = "student";
        var body = new FormData();
        body.append('func', 'getRole');
        this.$http.post('back/Authentication.php', body)
            .done(response => {
                role = response.data[0]
                return role;
            }, response => {
                if (response)
                    MessageService.errorMessage = response;
                else 
                    MessageService.errorMessage = "An unknown error occured"
                return role
            });
    }
}