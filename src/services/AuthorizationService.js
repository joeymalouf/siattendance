
import axios from 'axios'

export class AuthorizationService {

    constructor() {
    }

    async checkRole() {
        var role = "student";
        var body = new FormData();
        body.append('func', 'getRole');
        try {
            var res = await axios.post('back/Authentication.php', body)
            return res;
        }
        catch (e) {

            return role
        }
    }
    async setRole() {
        return "dude"
    }
}
