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
import AllSessions from './pages/AllSISessions'

Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(vuetify)


const routes = [{
  path: '/AllSessions',
  component: AllSessions
},
// {
//   path: '/session/:sessionid',
//   component: session,
//   beforeRouterEnter() {

//   },
// },
// {
//   path: '/attendance/:sessionid',
//   component: createAttendance
// },
// {
//   path: '/',
//   component: currentSessions
// },
// {
//   path: '/createUser',
//   component: createUser
// },
// {
//   path: '/createSession',
//   component: createSession
// },
// {
//   path: '/leader',
//   component: LeaderHome,
//   beforeEnter: (to, from, next) => {
//     var role = AuthorizationService.checkRole();
//     if (role == "leader" || role == "mentor" || role == "admin") {
//       next()
//     }
//     next(false)
//   },
//   children: [
//     {
//       path: '/home',
//       component: LeaderHome
//     }
//   ]
// },
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
