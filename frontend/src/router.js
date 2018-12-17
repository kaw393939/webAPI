import Vue from "vue";
import Router from "vue-router";

import Home from "./views/Home.vue";

Vue.use(Router);

export const routes = [
    {
        path: "/",
        component: Home
    },
    {
        path: "/login",
        component: () => import("./views/Login.vue")
    },
    {
        path: "/register",
        component: () => import("./views/Register.vue")
    },
    {
        path: "/profile/edit",
        component: () => import("./views/EditProfile.vue")
    },
    {
        path: "/profile",
        component: () => import("./views/UserProfile.vue")
    },
    {
        path: "/question",
        component: () => import("./views/QuestionCreate.vue")
    },
    {
        path: "/question/:id",
        component: () => import("./views/Question.vue")
    },
    {
        path: "*",
        component: () => import("./views/NotFound.vue")
    }
];

export default new Router({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});
