import Vue from "vue";
import Router from "vue-router";
import store from "@/store/";
import Home from "./views/Home.vue";

Vue.use(Router);

function ifNotAuthenticated(to, from, next) {
    if (!store.getters.isLoggedIn) {
        next({ path: "/" });
        return;
    }
    next();
}

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
        path: "/profile/:id",
        component: () => import("./views/UserProfile.vue")
    },
    {
        path: "/profile/:id/edit",
        beforeEnter: ifNotAuthenticated,
        component: () => import("./views/UserProfileEdit.vue")
    },
    {
        path: "/question",
        beforeEnter: ifNotAuthenticated,
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
