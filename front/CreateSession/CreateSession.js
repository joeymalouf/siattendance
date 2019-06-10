var createSession = Vue.component("createSession", {
    template: `
    <v-flex xs12 md7>
    <v-card elevation="12">
        <v-toolbar dark color="#14213d" height="36px">
            <v-toolbar-title>Create Session</v-toolbar-title>
            <v-spacer></v-spacer>
        </v-toolbar>
        <v-card-text>
            <v-form>
                <v-select :items="courses" label="Course" item-value="course" item-text="course" v-validate="'required'"
                    :error-messages="errors.collect('course')" data-vv-name="course" v-model="course" required></v-select>
                <v-select :items="professors" label="Professor" item-value="professor" item-text="professor" v-validate="'required'"
                    :error-messages="errors.collect('professor')" data-vv-name="professor" v-model="professor" required></v-select>
                <v-text-field v-model="type" v-validate="'required|max:30'" :counter="30"
                    :error-messages="errors.collect('type')" label="Type" data-vv-name="type" required>
                </v-text-field>
                <v-menu v-model="datemenu" :close-on-content-click="false" :nudge-right="40" lazy
                    transition="scale-transition" offset-y full-width min-width="290px">
                    <template v-slot:activator="{ on }">
                        <v-text-field v-model="date" label="Date" append-icon="event" readonly v-on="on"
                            v-validate="'required'" data-vv-name="date" :error-messages="errors.collect('date')">
                        </v-text-field>
                    </template>
                    <v-date-picker color="#14213d" v-model="date" @input="datemenu = false"></v-date-picker>
                </v-menu>
                <v-menu ref="timemenu" v-model="timemenu" :close-on-content-click="false" :nudge-right="40"
                    :return-value.sync="time" lazy transition="scale-transition" offset-y full-width max-width="290px"
                    min-width="290px">
                    <template v-slot:activator="{ on }">
                        <v-text-field color="#14213d" v-model="time" label="Time (military)" append-icon="access_time"
                            readonly v-on="on" v-validate="'required'" data-vv-name="time"
                            :error-messages="errors.collect('time')">
                        </v-text-field>
                    </template>
                    <v-time-picker color="#14213d" v-if="timemenu" v-model="time" format="24hr" full-width
                        @click:minute="$refs.timemenu.save(time)">
                    </v-time-picker>
                </v-menu>
                <v-btn @click="submit">+ Create</v-btn>
            </v-form>
        </v-card-text>
    </v-card>
</v-flex>
    `,
    data: function () {
        return {
            message: '',
            courses: [],
            professors: [],
            course: '',
            professor: '',
            type: '',
            date: null,
            time: null,
            datemenu: false,
            timemenu: false,
        }
    },
    watch: {
        course: function () {
            var body = new FormData();
            body.append('func', 'getCourseProfessors');
            body.append('course', this.course);
            this.$http.post('back/SISession.php', body)
                .then(response => {
                    this.professors = response.data;
                }, response => {
                    this.message = "Fail";
                });
        }
    },
    methods: {
        database() {
            var body = new FormData();
            body.append('func', 'getCourses');
            this.$http.post('back/SISession.php', body)
                .then(response => {
                    console.log(response.data);
                    this.courses = response.data;
                }, response => {
                    this.message = "Fail";
                });
        },
        submit() {

            if (this.$validator.validateAll()) {
                var body = new FormData();
                body.append('course', this.course);
                body.append('professor', this.professor);
                body.append('type', this.type);
                body.append('date', this.date);
                body.append('time', this.time);
                body.append('func', 'createSession');
                this.$http.post('back/SISession.php', body)
                    .then(response => {
                        router.push('/session/'+response.data);
                    }, response => {
                        this.message = "Fail";
                        console.log(response.data);
                    });
            }
        },
    },
    beforeMount() {
        this.database();
        today = new Date()
        this.date = (today.getFullYear() + "-" + (today.getMonth()+1) + "-" + today.getDate());
        
    },
    mounted() {
        this.$validator.localize('en', this.dictionary);
    },

});
