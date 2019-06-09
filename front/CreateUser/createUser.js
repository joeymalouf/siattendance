var createUser = Vue.component("createUser", {
    template: `
    <v-flex xs12 sm8 md4>
    <v-card elevation="12">
        <v-toolbar dark color="#14213d" height="36px">
            <v-toolbar-title>SI Sign Up</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-text>
            <v-form>
                <v-text-field v-model="fname" v-validate="'required|max:30'" :counter="30"
                    :error-messages="errors.collect('fname')" label="First Name" data-vv-name="fname" required>
                </v-text-field>
                <v-text-field v-model="lname" v-validate="'required|max:30'" :counter="30"
                    :error-messages="errors.collect('lname')" label="Last Name" data-vv-name="lname" required>
                </v-text-field>
                <v-text-field v-model="id" type="number" v-validate="'required|max:8'" :counter="8"
                    :error-messages="errors.collect('id')" label="Student ID Number" data-vv-name="id" required>
                </v-text-field>
                <v-btn @click="submit">submit</v-btn>
                <v-btn @click="clear">clear</v-btn>
            </v-form>
        </v-card-text>
    </v-card>
</v-flex>`,
    data: function () {
        return {
            message: '',
            fname: '',
            lname: '',
            id: '',
            dictionary: {
                custom: {
                    fname: {
                        required: () => "First name can not be empty.",
                    },
                    lname: {
                        required: () => "Last name can not be empty.",
                    },
                    id: {
                        required: () => "Student ID can not be empty.",
                    },
                }
            },
        }
    },
    methods: {
        submit() {
            if (this.$validator.validateAll()) {
                var body = new FormData();
                body.append('fname', this.fname);
                body.append('lname', this.lname);
                body.append('id', this.id);
                body.append('func', 'createUser');
                this.$http.post('back/User.php', body)
                    .then( response => {
                        console.log(response);
                    }, response => {
                        this.message = "Fail";
                        console.log(response);
                    });
            }

        },
        clear () {
            this.fname = ''
            this.lname = ''
            this.id = null
            this.$validator.reset()
          }
    },
    mounted () {
        this.$validator.localize('en', this.dictionary)
    },

});
