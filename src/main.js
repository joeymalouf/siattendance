// import Vue from 'vue'
// import App from './App.vue'
// import vuetify from './plugins/vuetify';

// Vue.config.productionTip = false

// new Vue({
//   vuetify,
//   render: h => h(App)
// }).$mount('#app')

import '@mdi/font/css/materialdesignicons.css'
import Vue from 'vue'
import App from './App'
import VueRouter from 'vue-router'
import vuetify from '@/plugins/vuetify'
import VeeValidate from 'vee-validate'
import axios from 'axios';
import AllSessions from './pages/AllSISessions'
import CreateUser from './pages/CreateUser'
import CreateAttendance from './pages/CreateAttendance'
import CreateSession from './pages/CreateSession'
import Session from './pages/SISession'
import CurrentSessions from './pages/CurrentSessions'
import LeaderHome from './pages/LeaderHome'
import MentorHome from './pages/MentorHome'
import { AuthorizationService } from './services/AuthorizationService'

Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(vuetify)

Vue.prototype.$http = axios

const authorizationService = new AuthorizationService()

const routes = [{
  path: '/AllSessions',
  component: AllSessions
},
{
  path: '/Session/:sessionid',
  component: Session,
  beforeRouterEnter() {

  },
},
{
  path: '/attendance/:sessionid',
  component: CreateAttendance
},
{
  path: '/',
  component: CurrentSessions
},
{
  path: '/CreateUser',
  component: CreateUser
},
{
  path: '/CreateSession',
  component: CreateSession
},
{
  path: '/Leader',
  component: LeaderHome,
  beforeEnter: async (to, from, next) => {
    var role = await authorizationService.checkRole().data
    if (role == "leader" || role == "mentor" || role == "admin") {
      next()
    }
    else {
      console.log(2)
      next(false)
    }
  },
  // children: [
  //   {
  //     path: '/',
  //     component: LeaderHome
  //   }
  // ]
},
{
  path: '/Mentor',
  component: MentorHome,
  beforeEnter: async (to, from, next) => {
    var role = await authorizationService.checkRole()
    role = role.data
    if (role == "mentor" || role == "admin") {
      next()
    }
    else {
      next(false)
    }
  },
  // children: [
  //   {
  //     path: '/',
  //     component: LeaderHome
  //   }
  // ]
},
];

const router = new VueRouter({
  base: "~/public_html/SIAttendance/",
  routes // short for `routes: routes`
})

new Vue({
  el: '#app',
  components: { App },
  $_veeValidate: {
    validator: 'new'
  },
  vuetify,

  watch: {},

  router,
  render: h => h(App)
})
