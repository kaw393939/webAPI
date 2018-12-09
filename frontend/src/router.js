import Vue from "vue";
import Router from "vue-router";

import Home from "./views/Home.vue";

Vue.use(Router);

export default new Router({
    mode: "history",
    base: process.env.BASE_URL,
    routes: [
        {
            path: "/",
            name: "home",
            component: Home
        },
        {
            path: "/login",
            name: "login",
            // route level code-splitting
            // this generates a separate chunk (about.[hash].js) for this route
            // which is lazy-loaded when the route is visited.
            component: () =>
                import(/* webpackChunkName: "about" */ "./views/Login.vue")
        },
        {
            path: "/register",
            name: "register",
            component: () => import("./views/Register.vue")
        },
        {
            path: "/password-recovery",
            name: "password-recovery",
            component: () => import("./views/PasswordRecovery.vue")
        },
        {
            path: "/profile/edit",
            component: () => import("./views/editProfile")
        },
        {
            path: "/question/:id",
            component: () => import("./views/Question.vue")
        },
        {
            path: "*",
            component: () => import("./views/NotFound.vue")
        }
    ]
});
