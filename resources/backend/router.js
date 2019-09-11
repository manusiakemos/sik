import Vue from 'vue';
import VueRouter from 'vue-router'
import store from './store'

// import TopNavigation from './views/layouts/TopNavigation'
import DefaultLayout from './views/layouts/DefaultLayout'

// import Welcome from './views/WelcomePage/WelcomePage';
import Profile from './views/ProfileComponent';

import Home from './views/Home';

import Puskesmas from './views/Puskesmas';

import Setting from './views/Setting';

import Login from './views/Login';

import User from './views/User';

import Bidan from "./views/Bidan";

import Reward from "./views/Reward";

// import UserCreate from './views/UserCreate';

Vue.use(VueRouter);

const router = new VueRouter({
  // mode: 'history',
  // base: process.env.BASE_URL,
  routes: [
    /* {
       path: '/',
       component: TopNavigation,
       children:[
         {
           path: '/',
           component: Welcome,
          /!* meta: {
             requiresAuth: true,
             role: 'super-admin|admin'
           }*!/
         }
       ]

     },*/
    /* {
      path: '/auth/:provider/callback',
      component: {
        template: '<div class="auth-component"></div>'
      }
    } */
    {
      path: '/default',
      component: DefaultLayout,
      children: [
        {
          path: '/home',
          component: Home,
          meta: {
            requiresAuth: true,
          }
        },
        {
          path: '/puskesmas',
          component: Puskesmas,
          meta: {
            requiresAuth: true,
            role: 'kominfo'
          }
        },
        {
          path: '/bidan',
          component: Bidan,
          meta: {
            requiresAuth: true,
            role: 'kominfo'
          }
        },
        {
          path: '/reward/:id',
          component: Reward,
          meta: {
            requiresAuth: true,
            role: 'kominfo'
          }
        },
        {
          path: '/profile',
          component: Profile,
          meta: {
            requiresAuth: true,
          }
        },
        {
          path: '/setting',
          component: Setting,
          meta: {
            requiresAuth: true
          }
        },
        {
          path: '/user',
          component: User,
          meta: {
            requiresAuth: true,
            role: 'kominfo'
          }
        },
       /* {
          path: '/user/create',
          component: UserCreate,
          meta: {
            requiresAuth: true,
            role: 'kominfo'
          }
        }*/
      ]
    },

    {
      path: '/',
      component: Login,
    },
  ]
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (store.state.auth.loggedIn == false) {
      next({
        path: '/',
        // params: { nextUrl: to.fullPath }
      })
    } else {
      if (screen.width < 1000 && !$("body").hasClass("sidebar-gone")) {
        $(document).find("#sidebar-toggler").data("toggle", "sidebar").click();
      }
      let user = store.state.auth.user;
      $.ajaxSetup({
        headers: {"Authorization": `Bearer ${user.api_token}`}
      });
      if (to.matched.some(record => record.meta.role)) {
        var userRole = user.role;
        var metaRole = to.meta.role;
        var splitMetaRole = metaRole.split('|');

        // console.log(userRole, metaRole, splitMetaRole);

        if (splitMetaRole.indexOf(userRole) > -1) {
          next()
          // console.log(userRole == metaRole);
        }
        else {
          // console.log(userRole == metaRole)
          next({path: '/'});
        }
      }
      next();
    }
  }

  else {
    next();
  }
});

export default router;
