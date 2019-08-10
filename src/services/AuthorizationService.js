
import axios from 'axios'

export class AuthorizationService {

    constructor() {
    }

    async checkRole() {
        var role = "student";
        var body = new FormData();
        body.append('func', 'getRole');
        try {
            var res = await axios.post('back/Authorization.php', body)
            return res.data;
        }
        catch (e) {

            return role
        }
    }
    async setRole() {
        return "dude"
    }
}
